<?php

namespace CPM\Task_List\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use CPM\Common\Traits\Model_Events;
use CPM\Task\Models\Task;
use CPM\Common\Models\Boardable;
use CPM\Comment\Models\Comment;
use CPM\File\Models\File;
use CPM\User\Models\User;
use CPM\Milestone\Models\Milestone;

class Task_List extends Eloquent {
    use Model_Events;

    protected $table = 'cpm_boards';

    protected $fillable = [
        'title',
        'description',
        'order',
        'project_id',
        'created_by',
        'updated_by',
    ];

    protected $attributes = ['type' => 'task-list'];

    public function newQuery( $except_deleted = true ) {
        return parent::newQuery( $except_deleted )->where( 'type', '=', 'task-list' );
    }

    public function boardables() {
        return $this->hasMany( Boardable::class, 'board_id' )->where( 'board_type', 'task-list' );
    }

    public function tasks() {
        return $this->belongsToMany( Task::class, 'cpm_boardables', 'board_id', 'boardable_id' )
            ->where( 'boardable_type', 'task' )
            ->where( 'board_type', 'task-list' )
            ->withPivot( 'order' );
    }

    public function comments() {
        return $this->hasMany( Comment::class, 'commentable_id' )->where( 'commentable_type', 'task-list' );
    }

    public function assignees() {
        return $this->belongsToMany( User::class, 'cpm_boardables', 'board_id', 'boardable_id')
            ->where( 'board_type', 'task-list' )
            ->where( 'boardable_type', 'user' );
    }

    public function files() {
        return $this->hasMany( File::class, 'fileable_id' )->where( 'fileable_type', 'task-list' );
    }

    public function milestones() {
        return $this->belongsToMany( Milestone::class, 'cpm_boardables', 'boardable_id', 'board_id' )
            ->where( 'board_type', 'milestone' )
            ->where( 'boardable_type', 'task-list' );
    }

}
