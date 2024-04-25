<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class CreateEvaluationsAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Tạo đánh giá';
    }

    public function getIcon()
    {
        return 'voyager-list-add';
    }

    public function getPolicy()
    {
        return 'add';
    }

    public function getAttributes()
    {
        return [
            'data-id' => $this->data->{$this->data->getKeyName()},
            'class' => 'btn btn-sm btn-primary pull-right create-evaluations',
            'style' => 'margin-right: 5px;',
            'id' => 'create-evaluations-'.$this->data->{$this->data->getKeyName()}
        ];
    }

    public function getDefaultRoute()
    {
        return 'javascript:;';
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'competitions';
    }
    public function shouldActionDisplayOnRow($row)
{
    return $row->status == 'ct';
}
}