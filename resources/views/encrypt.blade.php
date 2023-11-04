<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Encrypt</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <script src="{{asset('assets/js/mammoth.browser.min.js')}}"></script>
</head>
<body>
<div class="">
    <header class="header shadow p-3">
        <h1 class="text-center">Chữ ký RSA</h1>
    </header>

    <main class="mt-5 container">
        <div class="row">
            <div class="col-6 border-end pe-4">
                <div class="heading">
                    <h3>PHÁT SINH CHỮ KÝ</h3>
                </div>

                <form action="#" method="POST" class="mt-5" enctype="multipart/form-data">
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <label for="" class="" style="flex: 1">Văn bản ký:</label>
                        <textarea style="resize: none; flex: 2" class="message" name="message" id="" cols="30"
                                  rows="4">{{request()->message}}</textarea>
                        <input type="hidden" value="{{request()->textmd5}}" class="md5hidden">

                        <div style="flex: 1" class="d-flex justify-content-center">
                            <label for="file" class="sign btn btn-primary h-50 px-3">file</label>
                            <input id="file" type="file" name="file" hidden>
                        </div>
                    </div>

                    <div class="d-flex mt-5 flex-column d-none">
                        <div class="heading">
                            <h3 class="fs-6">Chọn số nguyên tố: </h3>
                        </div>

                        <div class="d-flex mt-3">
                            <label style="flex: 1;" for="p">P:</label>
                            <input style="flex: 2;" id="p" class="" type="text" name="p" value="{{!empty(request()->p)?request()->p:false}}">
                            <div style="flex: 1;"></div>
                        </div>

                        <div class="d-flex mt-3">
                            <label style="flex: 1;" for="q">P:</label>
                            <input style="flex: 2;" id="q" class="" type="text" name="q" value="{{!empty(request()->q)?request()->q:false}}">
                            <div style="flex: 1;"></div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex">
                        <button name="sign" type="submit" class="btn btn-primary m-auto px-4">Ký</button>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <label style="flex: 1;" for="" class="">Chữ ký:</label>
                        <textarea style="resize: none; flex: 2" class="ciphertext" name="ciphertext" id="" cols="30"
                                  rows="4">{{request()->ciphertext}}</textarea>
                        <div class="d-flex flex-column " style="flex: 1">
                            <a href="#" class="btn btn-primary h-50 px-3 m-1 move">Chuyển</a>
{{--                            <button type="submit" name="save" class="btn btn-primary h-50 px-3 m-1">Lưu</button>--}}
                            <a href="{{route('download').'?filename='.public_path('storage/output.txt')}}" class="btn btn-primary h-50 px-3 m-1">Lưu</a>
                        </div>
                    </div>
                    @csrf
                </form>
            </div>

            <div class="col-6 ps-4 border-start">
                <div class="heading">
                    <h3>KIỂM TRA CHỮ KÝ</h3>
                </div>

                <form action="#" method="POST" class="mt-5">
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <label style="flex: 1" for="" class="">Văn bản ký:</label>
                        <textarea style="resize: none; flex: 2" class="plaintext" name="" id="" cols="30"
                                  rows="4"></textarea>
                        <div style="flex: 1" class="d-flex justify-content-center">
                            <label for="fileraw" class="filemove btn btn-primary h-50 px-3">File văn bản</label>
                            <input id="fileraw" type="file" name="filemove" hidden>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <label style="flex: 1" for="" class="">Chữ ký:</label>
                        <textarea style="resize: none; flex: 2" class="signature" name="" id="" cols="30"
                                  rows="4"></textarea>
                        <div style="flex: 1" class="d-flex justify-content-center">
                            <label for="filesign" class="filemove btn btn-primary h-50 px-3">File chữ ký</label>
                            <input id="filesign" type="file" name="filemove" hidden>
                        </div>
                    </div>

                    <div class="mt-3 d-flex">
                        <a href="#" class="btn btn-primary m-auto px-4 check">Kiểm tra chữ ký</a>
                    </div>

                    <div class="d-flex align-items-center mt-5">
                        <label style="flex: 1" for="" class="">Thông báo</label>
                        <textarea style="resize: none; flex: 2" class="notify" name="" id="" cols="30"
                                  rows="4"></textarea>
                        <input type="hidden" value="{{request()->decryptedtext}}" class="hidden">
                        <div style="flex: 1"></div>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </main>

    <footer class="footer p-5"></footer>
</div>

<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
</body>
</html>








