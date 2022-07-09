new WOW().init();

jQuery(function ($) {
  var topBtn = $(".js-pagetop");
  topBtn.hide();

  // ボタンの表示設定
  $(window).scroll(function () {
    if ($(this).scrollTop() > 70) {
      topBtn.fadeIn();
    } else {
      topBtn.fadeOut();
    }
  });

  //ボタンをクリックしたらスクロールして上に戻る
  topBtn.click(function () {
    $("body,html").animate(
      {
        scrollTop: 0,
      },
      300,
      "swing"
    );
    return false;
  });

  //ドロワーメニュー
  $(".js-hamburger").on("click", function () {
    if ($(".js-hamburger").hasClass("is-open")) {
      $(".js-drawer-menu").fadeOut();
      $(this).removeClass("is-open");
    } else {
      $(".js-drawer-menu").fadeIn();
      $(this).addClass("is-open");
    }
  });

  //メニューと背景クリックでドロワーを閉じる
  $(".js-drawer-link,.js-drawer-menu").click(function () {
    $(".js-drawer-menu").fadeOut();
    $(".js-hamburger").removeClass("is-open");
  });

  // スクロールでヘッダーの色変化
  $(window).on("scroll", function () {
    var height = $(window).height();
    if (height < $(this).scrollTop()) {
      $(".js-header").addClass("is-change");
    } else {
      $(".js-header").removeClass("is-change");
    }
  });

  // スムーススクロール
  $(document).on("click", 'a[href*="#"]', function () {
    let time = 400;
    let header = $("header").innerHeight();
    let target = $(this.hash);
    if (!target.length) return;
    let targetY = target.offset().top - header;
    $("html,body").animate({ scrollTop: targetY }, time, "swing");
    return false;
  });

  let swipeOption = {
    loop: true,
    effect: "fade",
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    speed: 2000,
  };
  new Swiper(".swiper-container", swipeOption);

  // モダール（開く）
  $(".js-modal-open").click(function (e) {
    e.preventDefault();
    let target = $(this).data("target");
    $("." + target).addClass("is-show");
  });

  // モダール（閉じる）
  $(".js-modal-close").click(function (e) {
    e.preventDefault();
    let target = $(this).data("target");
    $("." + target).removeClass("is-show");
  });

  //formの入力確認
  var $submit = $("#js-form-submit");
  $("#js-contact-form input,#js-contact-form textarea").on(
    "change",
    function () {
      if (
        $('#js-contact-form input[type="text"]').val() !== "" &&
        $('#js-contact-form input[type="email"]').val() !== "" &&
        $("#js-contact-form textarea").val() !== "" &&
        $('#js-contact-form input[type="checkbox"]').prop("checked") === true
      ) {
        $submit.prop("disabled", false);
      } else {
        $submit.prop("disabled", true);
      }
    }
  );

  //loader
  $(function(){
    $(window).on('load',function(){
      $('.js-loader').delay(600).fadeOut(600);
      $('.js-loader-bg').delay(900).fadeOut(800);
  });
  
    setTimeout(function(){
      $('.js-loader,.js-loader-bg').fadeOut(600);
    },3000);
  });
});
