<?php

namespace App\Http\Controllers\RSA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;

class EncryptController extends Controller
{
    public function index()
    {
        return view('encrypt');
    }

    public function postMessage(Request $request)
    {
        $plaintext = '';
        $p = '';
        $q = '';

        if (isset($_FILES['file']['tmp_name']) && isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $plaintext = file_get_contents($_FILES['file']['tmp_name']);
        } else {
            $plaintext = $request->message;
        }

        if (!empty($request->p) && !empty($request->q)) {
            $p = $request->p;
            $q = $request->q;
        } else {
            $p = $this->generateRandomPrime();
            $q = $this->generateRandomPrime();
            while ($p == $q) {
                $q = $this->generateRandomPrime();
            }
        }

        $keys = $this->generateKeys($p, $q);

        $textmd5 = md5($plaintext);

        $ciphertext = $this->encrypt1($textmd5, $keys["private_key"]);
        $decrytedtext = $this->decrypt1($ciphertext, $keys["public_key"]);

        //lưu trữ file
        $content = $_POST['ciphertext'];
        $filename = 'output.txt';

        //truy cập đến ổ lưu trữ 'public'
        Storage::disk('public')->put($filename, $content);

        return redirect(route('index', [
            'message' => $plaintext,
            'textmd5' => $textmd5,
            'ciphertext' => $ciphertext,
            'decryptedtext' => $decrytedtext,
            'p' => $p,
            'q' => $q]));
    }

    public function download(Request $request) {
        if(!empty($request->filename)) {
            $filename = $request->filename;
            $filename = trim($filename);

            return response()->download($filename);
        }
    }



    //Thuật toán euclid mở rộng tìm ước chung lớn nhất
    function gcd($a, $b)
    {
        if ($b == 0) {
            return $a;
        }
        return $this->gcd($b, $a % $b);
    }




//Thuật toán Euclid mở rộng tìm phần tử nghịch đảo
    function modInverse($a, $m) {
        $m0 = $m;
        $y = 0;
        $x = 1;

        if ($m == 1) {
            return 0;
        }

        while ($a > 1) {
            $q = (int)($a / $m);
            $t = $m;
            $m = $a % $m;
            $a = $t;
            $t = $y;
            $y = $x - $q * $y;
            $x = $t;
        }

        if ($x < 0) {
            $x = $x + $m0;
        }

        return $x;
    }


//Hàm sinh cặp khóa RSA với tham số là hai số nguyên tố p và q
    function generateKeys($p, $q)
    {
        $n = $p * $q;
        $phi = ($p - 1) * ($q - 1);
        $e = 2;
        while ($e < $phi) {
            // Sử dụng hàm gcd để kiểm tra e có là số nguyên tố cùng nhau với phi(n) hay không
            if ($this->gcd($e, $phi) === 1) {
                break;
            }
            $e++;
        }
        $d = $this->modInverse($e, $phi); // Sử dụng hàm modInverse để tính toán khóa cá nhân
        return array("public_key" => array($e, $n), "private_key" => array($d, $n));
    }


//Thuat toan binh phuong va nhan
    function squaredMultipled($x, $n, $m)
    {
        $res = 1;
        while ($n > 0) {
            if ($n % 2 == 1) {
                $res = ($res * $x) % $m;
            }
            $x = ($x * $x) % $m;
            $n = (int)($n / 2);
        }
        return $res;
    }



// Hàm ký bản rõ
    function encrypt1($plaintext, $private_key)
    {
        $d = $private_key[0];
        $n = $private_key[1];

        $len = strlen($plaintext);

        $ciphertext = "";
        for ($i = 0; $i < $len; $i++) {
            $m = ord($plaintext[$i]); // Chuyển ký tự sang mã ASCII
            $c = $this->squaredMultipled($m, $d, $n); // Tính bản mã c
            $ciphertext .= "$c ";
        }
        return trim($ciphertext);
    }



// Hàm kiểm tra (giải mã chữ ký)
    function decrypt1($ciphertext, $public_key)
    {
        $e = $public_key[0];
        $n = $public_key[1];
        $chunks = explode(" ", $ciphertext);
        $len = count($chunks);
        $plaintext = "";
        for ($i = 0; $i < $len; $i++) {
            $c = intval($chunks[$i]);
            $m = $this->squaredMultipled($c, $e, $n); // Tính bản rõ m
            $plaintext .= chr($m); // Chuyển mã ASCII sang ký tự
        }
        return $plaintext;
    }





//    Hàm sinh số nguyên tố ngẫu nhiên
    function generateRandomPrime($min = 1000, $max = 9999)
    {
        $randomNum = rand($min, $max);

        if ($randomNum % 2 == 0) {
            $randomNum++;
        }

        while (!$this->isPrime($randomNum)) {
            $randomNum += 2;
        }

        return $randomNum;
    }

    function isPrime($n)
    {
        if ($n <= 1) {
            return false;
        }
        for ($i = 2; $i <= sqrt($n); $i++) {
            if ($n % $i == 0) {
                return false;
            }
        }
        return true;
    }
}
