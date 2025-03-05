<td>
    <table width="50%">
        <thead>
            <tr>
                <td><b><u>Billed To:</u></b></td>
            </tr>
            <tr>
                <td> <?= $records[$appkey]['app_name']; ?> </td>
            </tr>
            <tr>
                <td> <?= $records[$appkey]['app_email']; ?> </td>
            </tr>
            <tr>
                <td> <?= $records[$appkey]['app_phone']; ?> </td>
            </tr>
            <tr>
                <td> <?= $records[$appkey]['caddr']; ?> </td>
            </tr>
        </thead>
    </table>
</td>
</tr>

</table>
<br><br>
<table width="100%">
    <thead>
        <tr>
            <td><b>Booking ID:</b></td>
            <td><b>Slot Date:</b></td>
            <td><b>Paymode:</b></td>
        </tr>
        <tr>
            <td> <?= '#'.$appkey; ?> </td>
            <td> <?= showDate($records[$appkey]['app_date']); ?> </td>
            <td> <?= $records[$appkey]['app_paymode']; ?> </td>
        </tr>
    </thead>
</table>
<br><br>
<table width="100%" class="bill_tbl">
    <thead align="center">
        <tr>
            <th>S.No</th>
            <th>COURT</th>
            <th>HSN</th>
            <th>DURATION</th>
            <th>TIMING(s)</th>
            <th>AMOUNT (Rs.)</th>
        </tr>
    </thead>
    <tbody align="center">
        <?php
            if(!empty($records[$appkey]['serv_data'])) {
            $subtot = 0;
            foreach(ArrayTimeAlign($records[$appkey]['serv_data']) as $key => $item) {
            $i = 0;
            $courtname = (($item[0] == 'courtA') ? 'Court A' : 'Court B');
        ?>
        <tr>
            <td> <?= ++$key; ?> </td>
            <td> <?= $courtname; ?> </td>
            <td> </td>
            <td> <?= $item[1] . ' mins'; ?> </td>
            <td> <?= BookingTime($item[3]); ?> </td>
            <td> &#8377;<?= round(((float)$item[2] / 1.18), 2); $subtot += round(((float)$item[2] / 1.18), 2); ?> </td>
        </tr>
        <?php } } ?>
        <tr>
            <tr align="right">
                <th colspan="5">SUB TOTAL :</th>
                <td align="center"> <?= round($subtot, 2); ?> </td>
            </tr>
            <!-- <tr align="right">
                <th colspan="5"> DISCOUNT (<?= $records[$appkey]['cp_perc']; ?>%) : </th>
                <td align="center"> <?= round(($records[$appkey]['cp_amt']), 2); ?> </td>
            </tr> -->
            <tr align="right">
                <th colspan="5"> GST AMOUNT( 18% ) :</th>
                <td align="center"> 
                    <?= $gst = round(((float)$records[$appkey]['app_rate'] - ((float)$records[$appkey]['app_rate']/1.18)), 2); ?> 
                </td>
            </tr>
            <tr align="right">
                <th colspan="5">TOTAL : <br><small>(Including GST)</small></th>
                <td align="center"> <?= ((float)$subtot + $gst); ?> </td>
            </tr>
            <tr align="right">
                <th colspan="5">GRAND TOTAL :<br><small>(Round Off)</small> </th>
                <td align="center"> <?= round((float)$records[$appkey]['app_rate'], 2); ?> </td>
            </tr>
            <tr align="right">
                <th colspan="5">PAID :</th>
                <td align="center"> <?= round(($records[$appkey]['app_rate'] - $records[$appkey]['app_balance']), 2); ?> </td>
            </tr>
           
        </tr>
    </tbody>
</table>