<footer id="footer">
  Copyright <a href="index.php">Coffee note</a> All Rights Reserved.
</footer>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
        $(function(){
          //フッター下部固定の文です
          var $ftr = $('#footer');
          if(window.innerHeight > $ftr.offset().top + $ftr.outerHeight()){
            $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) +'px;'});
          }
          //メッセージ表示
          //パスワード変更画面で変更するボタンを押したあと、マイページに表示されるメッセージをJSで記述している
          //↓頭に$をつける（習わしです）ことによって、この変数にDOMが入ってるんだとわかるようになる
          var $jsShowMsg = $('#js-show-msg');
          var msg = $jsShowMsg.text();
          if(msg.replace(/^[\s　]+|[\s　]+$/g, "").length){
            $jsShowMsg.slideToggle('slow');
            setTimeout(function(){$jsShowMsg.slideToggle('slow'); }, 5000);
          }

          //画像ライブプレビュー
          var $dropArea = $('.area-drop');
          var $fileInput = $('.input-file');
          $dropArea.on('dragover', function(e){
            e.stopPropagation();
            e.preventDefault();
            $(this).css('border','3px #ccc dashed');
          });
          $dropArea.on('dragleave', function(e){
            e.stopPropagation();
            e.preventDefault();
            $(this).css('border', 'none');
          });
          $fileInput.on('change', function(e){
            $dropArea.css('border', 'none');
              var file = this.files[0], //2.files配列にファイルが入っている
                  $img = $(this).siblings('.prev-img'), //3.jQueryのsiblingsメソッドで兄弟のimgを取得
                  fileReader = new FileReader(); //4.ファイルを読み込むFileReaderオブジェクト
              //5.読込みが完了した際のイベントハンドラ。imgのsrcにデータをセット
              fileReader.onload = function(event){
                //読みこんだデータをimgに設定
                $img.attr('src',event.target.result).show();
              };

              //6.画像読込み
              fileReader.readAsDataURL(file);

            });

            //テキストエリアカウント
            var $countUp = $('#js-count'),
                $countView = $('#js-count-view');
            $countUp.on('keyup', function(e){
              $countView.html($(this).val().length);
            });
            //画像切替
            //商品詳細ページで画像クリックしたときに表示する画像を切り替えられるようにする記述
            var $switchImgSubs = $('.js-switch-img-sub'),
                $switchImgMain = $('#js-switch-img-main');
            $switchImgSubs.on('click',function(e){
              $switchImgMain.attr('src',$(this).attr('src'));
            });
            // お気に入り登録・削除
            var $like,
                likeProductId;
            $like = $('.js-click-like') || null; //nullというのはnull値という値で、「変数の中身は空ですよ」と明示するために使う値
            likeProductId = $like.data('productid') || null;
            // 数値の0はfalseと判定されてしまう。product_idが0の場合もありえるので、0もtrueとする場合にはundefinedとnullを判定する
            if(likeProductId !== undefined && likeProductId !== null){
              $like.on('click',function(){
                var $this = $(this);
                $.ajax({
                  type:"POST",
                  url: "ajaxLike.php",
                  data: { productId : likeProductId}
                }).done(function( data){
                  console.log('Ajax Success');//consoleに吐き出すと他ユーザーでも見れてしまうので、通常は吐き出さない。勉強のためわかりやすくているだけ
                  // クラス属性をtoggleでつけ外しする
                  $this.toggleClass('active');
                }).fail(function( msg){
                  console.log('Ajax Error');
                });
              });
            }
          });
</script>

</body>

</html>
