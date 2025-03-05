<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title> Appointment Invoice </title>
    <style type="text/css">
        body {
            font-family: sans-serif, fantasy, serif;
        }
        .bill_tbl table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .bill_tbl th {
            background-color: #F2F2F2;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .bill_tbl td {
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<table width="100%">
    <tr>
        <td width="80%">
            <img src="data:image/png;base64,<?= base64_encode(file_get_contents('../assets/images/company_imgs/'.$cmpy_info['fld_cmpylogo'])); ?>" width="30%" >
        </td>
        <td>
            <p> 
                <?= $cmpy_info['fld_cmpyname']; ?> </br> 
                <?= $cmpy_info['fld_cmpyemail']; ?> </br> 
                <?= $cmpy_info['fld_cmpyaddr']; ?> </br>
                <?= $cmpy_info['fld_cmpyphone']; ?>
            </p>
        </td>
    </tr>
</table>
<div style="float: right"> <b>Booked Date:</b> <?= date('d/m/Y', strtotime($records[$appkey]['book_date'])); ?></div>
<br>

<table width="100%">
    <tr>