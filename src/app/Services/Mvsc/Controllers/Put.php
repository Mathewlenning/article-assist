<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Models\MvscBase;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Validator;

/**
 * Handles CRUD Update operations on one or more records at a time.
 */
class Put extends Controller
{
    public function execute(): bool
    {
        /** @var MvscBase $model */
        $model = $this->getModel();
        $ids = $this->request->getIds();

        foreach ($ids AS $id)
        {
            $this->updateRecord($model->find($id));
        }

        $this->msgQue->addMessage('Record(s) updated');

        return $this->executeSubController();
    }

    protected function updateRecord(MvscBase $recordModel)
    {
        if (!$recordModel->authorize('update', $this->request->user()))
        {
            throw new AuthorizationException(code: 401);
        }

        $validated = $this->validateRequestInput($this->request, $recordModel);
        $newRecord = $validated + $recordModel->toArray();
        $recordModel->update($newRecord);
    }
}
