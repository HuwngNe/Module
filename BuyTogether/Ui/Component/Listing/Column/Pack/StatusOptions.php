<?php

namespace Ecommage\BuyTogether\Ui\Component\Listing\Column\Pack;

use Magento\Ui\Component\Listing\Columns\Column;

class StatusOptions extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        for ($i = 0; $i < count($dataSource["data"]["items"]); $i++) {
            if ($dataSource["data"]["items"][$i]["status"] == 1) {
                $dataSource["data"]["items"][$i]["statusType"] = __("Active");
            } else {
                $dataSource["data"]["items"][$i]["statusType"] = __("Non Active");
            }
        }
        return $dataSource;
    }
}
