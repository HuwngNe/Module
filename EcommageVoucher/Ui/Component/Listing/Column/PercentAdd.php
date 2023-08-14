<?php

namespace Ecommage\EcommageVoucher\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class PercentAdd extends Column
{

    /**
     * Custom percent voucher
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $count = count($dataSource["data"]["items"]);

        for ($i = 0; $i < $count; $i++) {
            $dataSource["data"]["items"][$i]["percentAdd"] = $dataSource["data"]["items"][$i]["percent"]."%";
        }

        return $dataSource;
    }

}
