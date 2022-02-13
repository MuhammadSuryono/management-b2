<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

    <style>
        .invoice-title h2, .invoice-title h3 {
            display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }
    </style>

    <title>Print - {{$limit->nama}}</title>
  </head>
  <body>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                <h2>Detail Budget</h2><h3 class="pull-right">Project : {{$limit->nama}}</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                        <strong>Nama Pengaju:</strong><br>
                            {{$limit->pengaju}}<br>
                            {{$limit->divisi_budget}}<br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Status:</strong><br>
                            {{$limit->status}}<br>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        {{-- <address>
                            <strong>Status:</strong><br>
                            {{$limit->status}}<br>
                        </address> --}}
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Tanggal Pembuatan :</strong><br>
                            {{date('F d Y', strtotime($limit->waktu))}}<br><br>
                        </address>
                    </div>
                </div>
            </div>
        </div>

        {{-- ARRAY SELESAI --}}
        <?php $dbSelesai = []; $jumlah=0;?>
        @foreach ($selesai as $db)
            <?php
                $nama = $db->divisi_budget;

                if(array_key_exists($nama, $dbSelesai)==true){
                    array_push($dbSelesai[$nama],$db);
                } else {
                    $dbSelesai[$nama] = array($db);
                }
            ?>
        @endforeach
        {{-- AKHIR ARRAY SELESAI --}}
        

        {{-- PERULANGAN BY DIVISI --}}
        @foreach ($divisi as $db)
        <?php $jumlah = $jumlah + (float)$db->jumlah;?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>{{$db->divisi_budget}}</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Item</strong></td>
                                        <td class="text-center"><strong>Price</strong></td>
                                        <td class="text-center"><strong>Quantity</strong></td>
                                        <td class="text-right"><strong>Totals</strong></td>
                                    </tr>
                                </thead>
                                <tbody>

                                    @for ($i = 0; $i < count($dbSelesai[$db->divisi_budget]); $i++)
                                    <tr>
                                        <td width="400">{{$dbSelesai[$db->divisi_budget][$i]->rincian}}</td>
                                        <td class="text-center">IDR {{number_format($dbSelesai[$db->divisi_budget][$i]->harga,0,'','.')}}</td>
                                        <td class="text-center">{{$dbSelesai[$db->divisi_budget][$i]->quantity}}</td>
                                        <td class="text-right">IDR {{number_format($dbSelesai[$db->divisi_budget][$i]->total,0,'','.')}}</td>
                                    </tr>

                                    @endfor

                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                        <td class="thick-line text-right">IDR {{number_format($db->jumlah, 0, '', '.')}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{-- AKHIR PERULANGAN BY DIVISI --}}
        
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Budget Summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"></td>
                                        <td class="no-line text-right"><strong>Grand Total :</strong>IDR {{number_format($jumlah,0,'','.')}}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"></td>
                                        <td class="no-line text-right"><strong>Total Limit : </strong>IDR {{number_format($limit->totalbudgetnow,0,'','.')}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <br>

                        <div class="row" style="margin-top:10px">
                            <table>
                                <thead>
                                    {{-- <span style="margin-left:100px"></span> --}}
                                    <th width="50px" align="center"></th>
                                    <th width="200px" align="center">Dibuat Oleh</th>
                                    <th width="200px" align="center">Diketahui Oleh</th>
                                    <th width="200px" align="right">Disetujui Oleh</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding-top: 50px;"></td>
                                        <td style="padding-top: 50px;"><strong><p>{{$limit->pengaju}} - {{$limit->divisi}}</p></strong></td>
                                        <td style="padding-top: 50px;"><strong><p>Manager Divisi {{$limit->divisi}}</p></strong></td>
                                        <td style="padding-top: 50px;"><strong><p>Ina Puspito - Direksi </p></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <div class="col-sm-1 text-center">
                                <h5>Dibuat Oleh</h5>
                                <br>
                                <br>
                                <br>
                                <strong><p>{{$limit->pengaju}} - {{$limit->divisi}}</p></strong>
                            </div>
                            <div class="col-sm-1 text-center">
                                <h5>Diketahui Oleh</h5>
                                <br>
                                <br>
                                <br>
                                <strong><p>Manager Divisi {{$limit->divisi}}</p></strong>
                            </div>
                            <div class="col-sm-1 text-center">
                                <h5>Disetujui Oleh</h5>
                                <br>
                                <br>
                                <br>
                                <strong><p>Ina Puspito - Direksi </p></strong>
                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> --}}
    <script>
        window.print();
    </script>
  </body>
</html>