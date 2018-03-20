<?php 

namespace WeDevs\PM\Core\Notifications\Emails;

/**
* Email Notification When a new project created
*/
use WeDevs\PM\Core\Notifications\Email;
use WeDevs\PM\Project\Models\Project;

class New_Message_Notification extends Email {
    
    function __construct() {

        add_action('pm_after_new_message_notification', array($this, 'trigger'), 10, 2 );
    }

    public function trigger( $message, $request ) {

        if ( empty( $request['notify_users'] ) ){
            return ;
        }

        $project      = Project::with('assignees', 'managers')->find( $request['project_id'] );
        $users        = array();
        $notify_users = explode( ',',  $request['notify_users'] );

        foreach ($notify_users as $u ) {
            if( $this->is_enable_user_notification( $u ) ){
                $users[] = $project->assignees->where('ID', $u)->first()->user_email;
            }
        }

        if( apply_filters('notify_project_managers', true) ){
            foreach ($project->managers as $u) {
                if(!in_array($u->user_email, $users)){
                    $users[] = $u->user_email;
                }
            }
        }

        if( !$users ){
            return ; 
        }

        $template_name = apply_filters( 'pm_new_message_email_template_path', $this->get_template_path( '/html/new-message.php' ) );
        $subject = sprintf( __( '[%s][%s] New Message: %s', 'pm' ), $this->get_blogname(), $project->title , $request['title'] );
        
        
        $message = $this->get_content_html( $template_name, [
            'id'          => $message['data']['id'],
            'title'       => $request['title'],
            'description' => $request['description'],
            'creator'     => $message['data']['creator']['data']['display_name'],
            'project_id'  => $project->id,
        ] );

        $this->send( $users, $subject, $message );

    }

}