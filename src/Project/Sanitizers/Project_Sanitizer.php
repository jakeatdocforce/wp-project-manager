<?php

namespace CPM\Project\Sanitizers;

use CPM\Core\Sanitizer\Abstract_Sanitizer;

class Project_Sanitizer extends Abstract_Sanitizer {
	public function filters() {
        return [
			'projectable_type' => 'trimer',
			'title'            => 'trimer|html_esc',
			'des'              => 'trimer|html_esc',
        ];
    }
}