<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <title>送信完了｜D.B.Academy</title>
  <meta name="description" content="元プロ野球トレーナーが、少年野球からプロを目指す方まで指導。筑波大学大学院卒などの実績を元に、他にはない科学的根拠のあるレッスン。東京都新宿にある完全個別指導の野球塾です。" />
  <!-- search-console -->
  <meta name="google-site-verification" content="" />
  <!-- ファビコン -->
  <link rel="icon" href="./images/common/favicon.ico" id="favicon">
  <link rel="apple-touch-icon" sizes="180x180" href="./images/common/apple-touch-icon-180x180.webp">
  <!-- css -->
  <link rel="stylesheet" href="./css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="./css/loaders.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./css/styles.css">
  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" defer></script>
  <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js" defer></script>
  <script src="./js/wow.min.js" defer></script>
  <script src="./js/script.js" defer></script>
</head>

<body>
  <header class="header js-header">
    <div class="header__inner">
      <h1 class="header__logo">
        <a href="/">
          <img src="./images/common/logo.webp" alt="ヘッダーロゴ">
        </a>
      </h1>
      <button class="header__drawer hamburger js-hamburger u-mobile" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <div class="header__sp-nav sp-nav js-drawer-menu u-mobile">
        <ul class="sp-nav__items">
          <li class="sp-nav__item"><a href="./index.html#mission">Mission<span>理念</span></a></li>
          <li class="sp-nav__item"><a href="./index.html#lesson">Lesson<span>レッスン</span></a></li>
          <li class="sp-nav__item"><a href="./index.html#price">Price<span>価格</span></a></li>
          <li class="sp-nav__item"><a href="./calendar_form01/calendar_form/sp.php">Reserve<span>体験予約</span></a></li>
          <li class="sp-nav__item"><a href="./index.html#profile">Profile<span>プロフィール</span></a></li>
          <li class="sp-nav__item"><a href="./index.html#access">Access<span>アクセス</span></a></li>
          <li class="sp-nav__item"><a href="./index.html#contact">Contact<span>お問い合わせ</span></a></li>
        </ul>
      </div>
      <!-- /.sp-nav -->

      <div class="header__pc-nav pc-nav u-desktop">
        <ul class="pc-nav__items">
          <li class="pc-nav__item"><a href="./index.html#lesson">Lesson<span>レッスン</span></a></li>
          <li class="pc-nav__item"><a href="./index.html#price">Price<span>価格</span></a></li>
          <li class="pc-nav__item"><a href="./calendar_form01/calendar_form/pc.php">Reserve<span>体験予約</span></a></li>
          <li class="pc-nav__item"><a href="./index.html#profile">Profile<span>プロフィール</span></a></li>
          <li class="pc-nav__item"><a href="./index.html#access">Access<span>アクセス</span></a></li>
          <li class="pc-nav__item"><a href="./index.html#contact">Contact<span>お問い合わせ</span></a></li>
          <li class="pc-nav__item"><a href="https://www.facebook.com/Diamond-Baseball-Academy-105361585161030/" target="_blank" rel="noopener noreferrer">
              <i class="fa-brands fa-facebook-square"></i></a></li>
        </ul>
      </div>
      <!-- /.pc-nav -->

    </div><!-- inner -->
  </header>

  <main>
    <div class="contact-done section-margin">
      <?php

      $your_name = $_POST['your_name'];
      $your_email = $_POST['your_email'];
      $your_message = $_POST['your_message'];

      print '<div class="contact-done__inner inner"> ';
      print '<p class="contact-done__name">' . $your_name . '様</p>';
      print '<p>お問い合わせいただきありがとうございます。</p><p>' . $your_email . 'にメールをお送りしますのでお待ちください。</p>';

      $honbun = '';
      $honbun .= $your_name . "様\n";
      $honbun .= "お世話になっております。Diamond.Baseball.Academyです。\n";
      $honbun .= "このたびはお問い合わせいただきありがとうございました。\n";
      $honbun .= "\n";
      $honbun .= "下記内容でお問い合わせを承りました。\n";
      $honbun .= "--------------------\n";
      $honbun .= $your_message . "\n";
      $honbun .= "--------------------\n";
      $honbun .= "※こちらは自動返信メールです。※\n";
      $honbun .= "\n";
      $honbun .= "担当者からの返信までしばらくお待ちくださいませ。\n";
      $honbun .= "\n";
      $honbun .= "■■■■■■■■■■■■■■■■\n";
      $honbun .= "Diamond Baseball Academy\n";
      $honbun .= "\n";
      $honbun .= "東京都新宿区\n";
      $honbun .= "TEL 000-000-0000\n";
      $honbun .= "■■■■■■■■■■■■■■■■\n";
      $title = '【D.B.Academy】お問い合わせが完了しました。';
      $header='From:hoge.com';
      $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
      mb_language('Japanese');
      mb_internal_encoding('UTF-8');
      mb_send_mail($your_email, $title, $honbun, $header);

      $title = 'お問い合わせがありました。';
      $header = 'From:' . $your_email;
      $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
      mb_language('Japanese');
      mb_internal_encoding('UTF-8');
      mb_send_mail('hoge.com',$title,$honbun,$header);

      ?>
      <div class="contact-done__home">
        <a class="contact-done__icon" href="index.html"><i class="fas fa-home"></i></a>
      </div>
    </div><!-- inner -->
    </div>

  </main>

  <footer id="footer" class="footer">
    <div class="footer__inner inner">

      <ul class="footer__list">
        <li class="footer__item"><a href="./index.html#mission">Mission<span>理念</span></a></li>
        <li class="footer__item"><a href="./index.html#lesson">Lesson<span>レッスン</span></a></li>
        <li class="footer__item"><a href="./index.html#price">Price<span>価格</span></a></li>
        <li class="footer__item u-mobile"><a href="./calendar_form01/calendar_form/sp.php">Reserve<span>体験予約</span></a></li>
        <li class="footer__item u-desktop"><a href="./calendar_form01/calendar_form/pc.php">Reserve<span>体験予約</span></a></li>
        <li class="footer__item"><a href="./index.html#profile">Profile<span>プロフィール</span></a></li>
        <li class="footer__item"><a href="./index.html#access">Access<span>アクセス</span></a></li>
      </ul>

      <div class="footer__footer">
        <a href="/" class="footer__logo">
          <img src="./images/common/logo.webp" alt="ロゴ">
        </a>
        <a class="footer__sns" href="https://www.facebook.com/Diamond-Baseball-Academy-105361585161030/" target="_blank" rel="noopener noreferrer">
          <i class="fa-brands fa-facebook-square"></i>
        </a>
      </div><!-- footer__footer -->

    </div>
    <!-- /.footer__inner inner -->
    <p class="footer__copyright"><small lang="en">&copy; 2021 Diamond Body Method</small></p>
  </footer>

</body>

</html>