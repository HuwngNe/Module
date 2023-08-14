<?php

namespace Ecommage\EcommageVoucher\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class StatusOptions extends Column
{
    /**
     * Custom status voucher
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $count = count($dataSource["data"]["items"]);

        for ($i = 0; $i < $count; $i++) {
            if ($dataSource["data"]["items"][$i]["status"] == 0) {
                $dataSource["data"]["items"][$i]["statusName"] = "Close";
            } else {
                $dataSource["data"]["items"][$i]["statusName"] = "Active";
            }
        }

        return $dataSource;
    }

}
