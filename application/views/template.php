<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tes ji</title>
    <style media="screen">
      table {
        border-collapse: collapse;
        width: 100%;
      }
      table tr th,td{
        border : 1px solid rgb(120, 120, 120);
        padding: 5px;
      }
    </style>
  </head>
  <body>
    <table>
      <tr>
        <th>No_surat</th>
        <td><?=$data_surat['no_surat']?></td>
      </tr>

      <tr>
        <th>tgl_surat</th>
        <td><?=$data_surat['tgl_surat']?></td>
      </tr>

      <tr>
        <th>dasar</th>
        <td><?=$data_surat['dasar']?></td>
      </tr>

      <tr>
        <th>untuk</th>
        <td><?=$data_surat['untuk']?></td>
      </tr>

      <tr>
        <th>Menugaskan</th>
        <td>
          <table>
            <?php $no = 1; foreach ($data_kepala_badan as $key): ?>

            <tr>
              <td><?=$no++?></td>
              <td>
                <ul>
                  <li>Nip : <?=$key['nip']?></li>
                  <li>Nama : <?=$key['nama']?></li>
                  <li>Jabatan : <?=$key['jabatan']?></li>
                </ul>
              </td>
            </tr>
          <?php endforeach; ?>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
