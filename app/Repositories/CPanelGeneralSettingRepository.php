<?php
/**
 * Laravella CMS
 * File: CPanelGeneralSettingRepository.php
 * Created by Elman (https://linkedin.com/in/huseyn0w)
 * Date: 25.07.2019
 */

namespace App\Repositories;


use App\Http\Models\CPanel\CPanelGeneralSettings;
use Illuminate\Database\QueryException;

class CPanelGeneralSettingRepository extends BaseRepository
{

    public function __construct(CPanelGeneralSettings $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function update($updatedRequest, $id = 1)
    {

        try {
            $newData = $updatedRequest->except(['_token']);
            $settings_column = $this->model::firstOrFail();
            $settings_column->update($newData);
            $result = true;

        } catch (QueryException $e) {
            $result = $e->errorInfo;

        }

        return $result;
    }


}