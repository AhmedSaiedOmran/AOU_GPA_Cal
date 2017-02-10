<!doctype html>
<html class="no-js" lang="en" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>اسبة الدراجات</title>
  <link rel="stylesheet" href="css/foundation.css">
  <link rel="stylesheet" href="css/app.css">
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>

  <style type="text/css">
  * { 
   font-family: 'DroidArabicKufiRegular'; 
   font-weight: normal; 
   font-style: normal; 
}

    body {
  background: #F0F0F3;
}
.login-box {
  background: #fff;
  border: 1px solid #ddd; 
  margin: 100px 0;
  padding: 40px 20px 0 20px;
}
  </style>
</head>
<body>

  <div class="row align-center align-middle ">
    <div class="large-5 medium-8 small-12 large-centered columns">
      <div class="login-box">
        <div class="row">
          <div class="large-12 columns">
          <p>أدخل اسم المستخدم وكلمة السر</p>
          <?php
if (isset($_GET['error'])){
	echo "<p style='color:Red;'>أسم مستخدم او كلمة مرور خطأ</p>";
}
?>

            <form action="calc.php" method="post">
             <div class="row">
               <div class="large-12 columns">
                 <input type="text" name="ID" placeholder="أسم المستخدم" />
               </div>
             </div>
             <div class="row">
               <div class="large-12 columns">
                 <input type="password" name="PASS" placeholder="كلمة السر" />
               </div>
             </div>
             <div class="row">
              <div class="large-12 large-centered columns">
                <input type="submit" name="submit" class="button expand" value="تسجيل الدخول"/>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
