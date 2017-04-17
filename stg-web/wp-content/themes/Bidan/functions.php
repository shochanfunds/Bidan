<?php


add_theme_support('post-thumbnails');
add_filter( 'post_thumbnail_html', 'custom_attribute' );
remove_filter( 'pre_term_description', 'wp_filter_kses' );
set_post_thumbnail_size( 220, 150, true );
register_sidebar(
  array(
    'before_widget' => "<div class='widget'>",
    'after_widget' => "</div>",
    'before_title' => "<h2>",
    'after_title' => "</h2>",

  )
);

function custom_attribute( $html ){
    $myclass = ''; // クラス名
    return preg_replace('/class=".*\w+"/', 'class="'. $myclass .'"', $html);
}






function wp_pagination() {
	global $wp_query;
	$big = 99999999;
	$page_format = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
    'prev_next'    => True,
    'prev_text'    => __('« Prev'),
    'next_text'    => __('Next »'),
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'type'  => 'array'
	) );
	if( is_array($page_format) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		echo '<ul class="list-inline list-unstyled">';
		foreach ( $page_format as $page ) {
    		echo "<li>$page</li>";
		}
			echo '</ul>';
	}
	wp_reset_query();
}


//Custom CSS Widget
add_action('admin_menu', 'custom_css_hooks');
add_action('save_post', 'save_custom_css');
add_action('wp_head','insert_custom_css');
function custom_css_hooks() {
    add_meta_box('custom_css', '個別CSS', 'custom_css_input', 'post', 'normal', 'high');
    add_meta_box('custom_css', '個別CSS', 'custom_css_input', 'page', 'normal', 'high');
}
function custom_css_input() {
    global $post;
    echo '<input type="hidden" name="custom_css_noncename" id="custom_css_noncename" value="'.wp_create_nonce('custom-css').'" />';
    echo '<textarea name="custom_css" id="custom_css" rows="5" cols="30" style="width:100%;">'.get_post_meta($post->ID,'_custom_css',true).'</textarea>';
}
function save_custom_css($post_id) {
    if (!wp_verify_nonce($_POST['custom_css_noncename'], 'custom-css')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
    $custom_css = $_POST['custom_css'];
    update_post_meta($post_id, '_custom_css', $custom_css);
}
function insert_custom_css() {
    if (is_page() || is_single()) {
        if (have_posts()) : while (have_posts()) : the_post();
            if (get_post_meta(get_the_ID(), '_custom_css', true) !='') {
                echo "<style type=\"text/css\" media=\"all\">\n".get_post_meta(get_the_ID(), '_custom_css', true)."\n</style>\n";
        }
        endwhile; endif;
        rewind_posts();
    }
}



function add_cat_slug_class( $output, $args ) {
    $regex = '/<li class="cat-item cat-item-([\d]+)[^"]*">/';
    $taxonomy = isset( $args['taxonomy'] ) && taxonomy_exists( $args['taxonomy'] ) ? $args['taxonomy'] : 'category';

    preg_match_all( $regex, $output, $m );

    if ( ! empty( $m[1] ) ) {
        $replace = array();
        foreach ( $m[1] as $term_id ) {
            $term = get_term( $term_id, $taxonomy );
            if ( $term && ! is_wp_error( $term ) ) {
                $replace['/<li class="col-xs-3 cat-item cat-item-' . $term_id . '("| )/'] = '<li class="col-xs-3 cat-item cat-item- ' . $term_id . ' cat-item-' . esc_attr( $term->slug ) . '$1';
            }
        }
        $output = preg_replace( array_keys( $replace ), $replace, $output );
    }
    return $output;
}
add_filter( 'wp_list_categories', 'add_cat_slug_class', 10, 2 );

function new_excerpt_length($length) {
     return 200;
}
add_filter('excerpt_length', 'new_excerpt_length');

add_editor_style( 'css/style.css' );
add_editor_style( 'css/base.css' );



function post_judge() {

echo '<input type="button" value="チェックボタン" onclick="check_post()"><span id="check_now"></span>';

echo '<p id="check_post_1">①通常見出しを10個以上 <br/><span id="check_1">NG</span></p>';
echo '<p id="check_post_2">②タイトルの長さが２８~３２文字 <br/><span id="check_2">NG</span></p>';
echo '<p id="check_post_3">③画像とYoutubeを合わせて3個以上 <span id="check_3">NG</span></p>';
echo '<p id="check_post_4">④コメントを合計5個以上 ※コメントは画像とか引用などに対する簡単な文章です <span id="check_4"></span></p>';
echo '<p id="check_post_5">⑤引用・コメントを合計4個以上 <span id="check_5"></span></p>';
echo '<p id="check_post_6">⑥タイトルとページの説明(ディスクリプション)がオリジナル <span id="check_6"></span></p>';
echo '<p id="check_post_7">⑦見出し中に各キーワード３個以上→各キーワードとは「加齢臭,部位」であれば「加齢臭」で３個以上、「部位」で３個以上です。<span id="check_7">NG</span></p>';
echo '<p id="check_post_8">⑧合計で各キーワードを２０個以上 <span id="check_8">NG</span></p>';
echo '<p id="check_post_9">⑨記事の説明(ディスクリプション)の中に各キーワード2個以上 <span id="check_9">NG</span></p>';
echo '<p id="check_post_10">⑩記事の説明(ディスクリプション)は１１０〜１３０文字 <br/><span id="check_10">NG</span></p>';
echo '<p id="check_post_11">⑪文字数合計2500字〜 <br/><span id="check_11">NG</span></p>';
echo '<p id="check_post_12">⑫全体で引用率が40%は超えないようにする <br/><span id="check_12">NG</span></p>';
echo '<p id="check_post_13">⑬タグを5個以上入れる <br/><span id="check_13">NG</span></p>';
echo '<p id="check_post_14">⑭アイキャッチ画像を入れる <br/><span id="check_14">NG</span></p>';
echo '<p id="check_post_15">⑮タイトルの中にキーワードを1つは入れる <br/><span id="check_15">NG</span></p><br />';

}

add_action('admin_menu', 'add_custom_fields');
function add_custom_fields() {
  add_meta_box( 'my_sectionid_judge', '記事のチェックポイント', 'post_judge', 'post');
}


function my_admin_script() {
  echo '<script>
var box;//記事の本文のHTML
var box_text;//記事のテキスト
var title_value//記事のタイトル
var title_now;//編集画面タイトルのテキスト
var title_num;//タイトル文字数
var description_value;//ディスクリプションのテキスト
var description_num;//ディスクリプションの文字数
var word_count;//記事の全文字数
var tag_h_num;//見出しタグの合計個数
var tag_img_num;//画像タグの個数
var keywords;//キーワード
var h_keywords_check;//各見出し中のキーワード数
var h_keywords_num;//見出し中のキーワード数合計
var key_num_title;//タイトル中に含むキーワード数
var key_num_description;//ディスクリプションに含まれるキーワード数
var key_num_post;//記事に含まれるキーワード数
var quote_text_num;//引用のテキスト文字数

var words_tag_num;//記事の単語タグの個数

var keyword_each = [ "" , "" , "" , "" , "", "",""];//キーワード
var keyword_each_description = [ "" , "" , "" , "" , "", "",""];//キーワード
var keyword_each_h = [	["","","","","","","","","","","","","","","",""],
			["","","","","","","","","","","","","","","",""],
			["","","","","","","","","","","","","","","",""],
			["","","","","","","","","","","","","","","",""],
			["","","","","","","","","","","","","","","",""]];


var tags_h1;
var tags_h2;
var tags_h3;

function check_tag_h(){
box =  document.getElementsByTagName("iframe")[0].contentWindow.document;
box_text = box.querySelector("#tinymce").innerText;

var tag_checklist = document.querySelector(".tagsdiv");
words_tag_num = tag_checklist.getElementsByTagName("span").length;

tags_h1 = box.getElementsByTagName("h1");
tags_h2 = box.getElementsByTagName("h2");
tags_h3 = box.getElementsByTagName("h3");


var tags_img  = box.getElementsByTagName("img");
var quote     = box.getElementsByTagName("blockquote");

quote_text_num = 0;
for(var i=1 ; i <= quote.length; i++){
	quote_text_num += quote[i-1].innerText.length;
}

tag_h_num   = tags_h1.length + tags_h2.length + tags_h3.length;
tag_img_num = tags_img.length;

  h_keywords_num = 0;
  h_keywords_check = false;
  if(keywords != ""){
    for(var i=0 ; i < keywords.length ; i++){
  h_keywords_num = 0;

        for(var j=0 ; j < tags_h1.length ; j++){
        h_keywords_num += tags_h1[j].innerText.split(keywords[i]).length - 1;
	keyword_each_h[i][j] = tags_h1[j].innerText.split(keywords[i]).length - 1;
        }
        for(var j=0 ; j < tags_h2.length ; j++){
        h_keywords_num += tags_h2[j].innerText.split(keywords[i]).length - 1;
        }
	for(var j=0 ; j < tags_h3.length ; j++){
        h_keywords_num += tags_h3[j].innerText.split(keywords[i]).length - 1;
        }

        if(h_keywords_num >= 3){
          h_keywords_check = true;
        }else{
          h_keywords_check = false;
          break;
        }
    }
  }

}

function ShowLength(str) {
      description_value = str;
      description_num = countLength(str);
      document.getElementById("inputlength").innerHTML = "文字数: " + description_num;
   }

function ShwLength_title( str ){
      title_value = str;
      title_num = countLength(str);
      document.querySelector("div.wrap > h1").innerHTML = title_now + "  タイトル文字数: " + title_num;
}

function countLength(str){
    var r = 0;
    for (var i = 0; i < str.length; i++) {
        var c = str.charCodeAt(i);
        if ((c >= 0x0 && c < 0x81) || (c == 0xf8f0) || (c >= 0xff61 && c < 0xffa0) || (c >= 0xf8f1 && c < 0xf8f4)) {
            r += 0.5;
        } else {
            r += 1;
        }
    }
    return r;
}

window.onload = function () {
  title_value = document.getElementById("title").value;
  title_now = document.querySelector("div.wrap > h1").innerText;
  title_num = countLength(document.getElementById("title").value);
  description_value = document.getElementById("description_input").value;
  description_num = countLength(document.getElementById("description_input").value);
  keywords = document.getElementById("keywords_input").value.split(",");

  word_count = document.querySelector(".word-count").innerText;
  word_count = parseInt(word_count);

  document.querySelector("div.wrap > h1").innerHTML = title_now + "  タイトル文字数: " + title_num;
  document.getElementById("title").setAttribute("onkeyup","ShwLength_title(value);");

check_post();
textCheckAlert();
};

function check_post(){
  check_tag_h();

　word_count = document.querySelector(".word-count").innerText;
  word_count = parseInt(word_count);

  keywords = document.getElementById("keywords_input").value.split(",");

  key_num_description = 0;
  key_num_post = 0;
  key_num_title = 0;

if(keywords != ""){
  for(var i=0 ; i<keywords.length ; i++){
  	key_num_description += description_value.split(keywords[i]).length - 1;
	keyword_each_description[i] = description_value.split(keywords[i]).length - 1;

	key_num_post += box_text.split(keywords[i]).length - 1;
	keyword_each[i] = box_text.split(keywords[i]).length - 1;

	key_num_title += title_value.split(keywords[i]).length - 1;
  }
}

  if(tag_h_num >= 10){
	document.getElementById("check_1").innerHTML = "OK 現在見出し：" + tag_h_num + "個";
	document.getElementById("check_post_1").classList.add("check_ok");
	}else{
	document.getElementById("check_1").innerHTML = "NG 現在見出し：" + tag_h_num + "個";
	document.getElementById("check_post_1").classList.remove("check_ok");
	}

	if(title_num >= 28 && title_num < 33){
	document.getElementById("check_2").innerHTML = "OK 現在タイトル文字数：" + title_num + "文字";
	document.getElementById("check_post_2").classList.add("check_ok");
	}else{
	document.getElementById("check_2").innerHTML = "NG 現在タイトル文字数：" + title_num + "文字";
	document.getElementById("check_post_2").classList.remove("check_ok");
	}

  	if(tag_img_num >= 3){
	document.getElementById("check_3").innerHTML = "OK<br/>画像" + tag_img_num + "枚";
	document.getElementById("check_post_3").classList.add("check_ok");
	}else{
	document.getElementById("check_3").innerHTML = "NG<br/>画像" + tag_img_num + "枚";
	document.getElementById("check_post_3").classList.remove("check_ok");
	}


  if(h_keywords_check == true){
	document.getElementById("check_7").innerHTML = "OK<br/>";
   for(var i=0 ; i < keywords.length ; i++){
        for(var j=0 ; j < tags_h1.length ; j++){
	document.getElementById("check_7").innerHTML += keywords[i] + ":" + (j+1) + "番目の見出し:" + keyword_each_h[i][j] + "個<br/>";
	}
    }
	document.getElementById("check_post_7").classList.add("check_ok");
	}else{
	document.getElementById("check_7").innerHTML = "NG<br/>";
  	 for(var i=0 ; i < keywords.length ; i++){
        for(var j=0 ; j < tags_h1.length ; j++){
	document.getElementById("check_7").innerHTML += keywords[i] + ":" + (j+1) + "番目の見出し:" + keyword_each_h[i][j] + "個<br/>";
	}
    }
	document.getElementById("check_post_7").classList.remove("check_ok");
  }


	var key_check_flag = true;

	for(var i=0 ; i<keywords.length ; i++){
		if(keyword_each[i] < 20 ){
			key_check_flag = false;
		}
  	}

	if(key_num_post >= 20 * keywords.length && key_check_flag == true){
	document.getElementById("check_8").innerHTML = "OK キーワード数" + key_num_post + "<br/>";

	for(var i=0 ; i<keywords.length ; i++){
	document.getElementById("check_8").innerHTML += keywords[i] + ":" + keyword_each[i] + "個<br/>";
		if(keyword_each[i] < 20 ){
			key_check_flag = false;
		}
  	}

	if(key_check_flag == true){
		document.getElementById("check_post_8").classList.add("check_ok");
	}

	}else{
		if(keywords == ""){
		document.getElementById("check_8").innerHTML = "キーワードが設定されていません";
		}else{
		document.getElementById("check_8").innerHTML = "NG<br/>";
			for(var i=0 ; i<keywords.length ; i++){
			document.getElementById("check_8").innerHTML += keywords[i] + ":" + keyword_each[i] + "個<br/>";
  			}
		}
	document.getElementById("check_post_8").classList.remove("check_ok");
	}

	key_check_flag = true;

	for(var i=0 ; i<keywords.length ; i++){
		if(keyword_each_description[i] < 2 ){
			key_check_flag = false;
		}
	}

	if(key_num_description >= 2  * keywords.length && key_check_flag == true){

	document.getElementById("check_9").innerHTML = "OK<br/>";
	for(var i=0 ; i<keywords.length ; i++){
	document.getElementById("check_9").innerHTML += keywords[i] + ":" + keyword_each_description[i] + "個<br/>";
		if(keyword_each_description[i] < 2 ){
			key_check_flag = false;
		}
	}
	if(key_check_flag == true)document.getElementById("check_post_9").classList.add("check_ok");

	}else{
	document.getElementById("check_9").innerHTML = "NG<br/>";
	for(var i=0 ; i<keywords.length ; i++){
			document.getElementById("check_9").innerHTML += keywords[i] + ":" + keyword_each_description[i] + "個<br/>";
  			}
	document.getElementById("check_post_9").classList.remove("check_ok");
	}

	if(description_num >= 110 && description_num < 131){
	document.getElementById("check_10").innerHTML = "OK";
	document.getElementById("check_post_10").classList.add("check_ok");
	}else{
	document.getElementById("check_10").innerHTML = "NG";
	document.getElementById("check_post_10").classList.remove("check_ok");
	}

	if(word_count >= 2500){
	document.getElementById("check_11").innerHTML = "OK 文字数合計" + word_count;
	document.getElementById("check_post_11").classList.add("check_ok");
	}else{
	document.getElementById("check_11").innerHTML = "NG 文字数合計" + word_count;
	document.getElementById("check_post_11").classList.remove("check_ok");
	}

var quote_rate = (quote_text_num / (word_count+1));
	if( quote_rate <= 0.40){
	document.getElementById("check_12").innerHTML = "OK 引用率" + Math.round(quote_rate*100) + "%";
	document.getElementById("check_post_12").classList.add("check_ok");
	}else{
	document.getElementById("check_12").innerHTML = "NG 引用率" + Math.round(quote_rate*100) + "%";
	document.getElementById("check_post_12").classList.remove("check_ok");
	}

  if(words_tag_num >= 5){
	document.getElementById("check_13").innerHTML = "OK タグ数" + words_tag_num;
	document.getElementById("check_post_13").classList.add("check_ok");
	}else{
	document.getElementById("check_13").innerHTML = "NG タグ数" + words_tag_num;
	document.getElementById("check_post_13").classList.remove("check_ok");
	}

  if(document.getElementById("remove-post-thumbnail")){
	document.getElementById("check_14").innerHTML = "OK";
	document.getElementById("check_post_14").classList.add("check_ok");
	}else{
	document.getElementById("check_14").innerHTML = "NG";
	document.getElementById("check_post_14").classList.remove("check_ok");
	}

  if(key_num_title >= 1){
	document.getElementById("check_15").innerHTML = "OK キーワード数:"+key_num_title;
	document.getElementById("check_post_15").classList.add("check_ok");
	}else{
	document.getElementById("check_15").innerHTML = "NG キーワード数:"+key_num_title;
	document.getElementById("check_post_15").classList.remove("check_ok");
   }

  document.getElementById("check_now").innerHTML = "　反映しました！";
  setTimeout("check_ok()", 1000);
}

function check_ok(){
  document.getElementById("check_now").innerHTML = "";
}

var obj2 = document.querySelector(".mce-i-image");
obj2.addEventListener( "click" , function () {
var obj3 = document.querySelector(".mce-widget .mce-label .mce-abs-layout-item .mcd-first");
if(obj3.innerText == "Image caption"){
	obj3.innerText = "画像のコメント";
}
} , false );



  </script>'.PHP_EOL;
}

add_action('admin_print_scripts-post.php', 'my_admin_script');
add_action('admin_print_scripts-post-new.php', 'my_admin_script');


add_action('admin_menu', 'add_custom_fields');

//ビジュアルエディタのcssを追加
add_editor_style( 'editor-style.css' );

//'editor-area'というクラスを割り当てる
function custom_editor_settings( $initArray ){
	$initArray['body_class'] = 'editor-area';
	return $initArray;
}
add_filter( 'tiny_mce_before_init', 'custom_editor_settings' );



/*アフィリエイトコード*/

function code_a1() {
return '
<a onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” href="https://px.a8.net/svt/ejp?a8mat=2NSTV9+F4RNAQ+398K+BWVTE" ><img class="wp-temp-img-id" title="" src="http://hottab.zegal.co.jp/wp-content/uploads/2014/11/thumbnail_100_001.jpg" alt="薬用Hottab"/></a>

<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NSTV9+F4RNAQ+398K+BWVTE" target="_blank">重炭酸湯 薬用Hot Tab</a>

<p>重炭酸イオン・クエン酸・水素イオンが入った安心安全日本国産のタブレット。</p>

<p>石鹸、シャンプーでは洗浄できないミネラル皮脂汚れをしっかり洗い流します。<p>

<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NSTV9+F4RNAQ+398K+BWVTE" target="_blank"><span>⇒公式サイトはこちら</span></a>
<p>&nbsp;</p>';
}

function code_a2() {
return '<a onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});”  href="https://px.a8.net/svt/ejp?a8mat=2NR38D+A4DB02+2O22+2BMJMQ"><img class="wp-temp-img-id" title="" src="http://薬用ネオテクトの口コミ.com/img/neo8.png" alt="ネオテクト" /></a>

&nbsp;

<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NR38D+A4DB02+2O22+2BMJMQ">【薬用ネオテクト】</a>
<p>臭いの原因菌を99.999%殺滅する医療のプロが認めた高い消臭力、制汗力を発揮する2016年最新の薬用クリームです。</p>
<p>無添加かつ、限りなくお肌に優しい天然植物由来エキスを原料にしています。</p>

<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NR38D+A4DB02+2O22+2BMJMQ" target="_blank"><span>⇒公式サイトはこちら</span></a>

&nbsp;

&nbsp;';
}


function code_a3() {
return '<a onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” href="http://suiso-bath.jp/?bi"><img class="wp-temp-img-id" src="http://litaheart.com/img/bg_jigyou.jpg" alt="水素ぶろ"/></a>

<br/>

<a class="button" href="http://suiso-bath.jp/?bi"><span>→詳しくはこちら！</span></a>
<br/>
<a class="product" href="http://suiso-bath.jp/?is">【リタライフ水素風呂初月無料キャンペーン中】</a>
';
}


function code_a4() {
return '<a onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” href="https://px.a8.net/svt/ejp?a8mat=2NR38D+A1ZKKY+CW6+749TMQ" target="_blank"><img class="wp-temp-img-id" title="" src="https://www.eterno-kenkoucorp.com/media/img/product/be0148_l.jpg" alt="薬用柿渋石鹸"/><img src="https://px.a8.net/svt/ejp?a8mat=2NR38D+A1ZKKY+CW6+749TMQ" alt="" /></a>

<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NR38D+A1ZKKY+CW6+749TMQ">【薬用柿渋石鹸】</a>

<p>体臭対策をしている人なら一度は使ったことがある柿渋石鹸。</p>

<p>安心安全の自然由来の成分で、体臭の原因菌を殺菌・抑制します。</p>

<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NR38D+A1ZKKY+CW6+749TMQ" target="_blank"><span>→公式サイトはこちら</span></a>
<img src="https://px.a8.net/svt/ejp?a8mat=2NR38D+A1ZKKY+CW6+749TMQ" alt="" border="0" />

&nbsp;';
}

function code_a5() {
return '<a onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” href="https://px.a8.net/svt/ejp?a8mat=2NR38D+9YEYYA+37F0+HUKPU&amp;a8ejpredirect=https%3A%2F%2Ffinebase.jp%2Fmensdeo7200.html%3Fad_key%3Ddeo8" target="_blank"><img class="wp-temp-img-id" title="" src="http://byebye体臭.com/wp-content/uploads/2015/10/mensdeo8400-pack-300x218.jpg" alt="" /><strong>【MEN`s Deo】<img src="https://www16.a8.net/0.gif?a8mat=2NR38D+9YEYYA+37F0+BYT9D" alt="体臭・消臭サプリメントメンズデオ" /></strong></a>

<p><span>GMP基準認定・HACCP・有機JAS認定と徹底した品質管理をされた国産サプリメント。</span></p>

<p>期間限定71%OFFキャンペーン中↓↓</p>

<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NR38D+9YEYYA+37F0+BYT9D" target="_blank"><span>→公式サイトはこちら</span></a>

&nbsp;
';
}

function code_a6() {
return '<img onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” class="wp-temp-img-id" title="" src="http://estheticstaiken.com/wp-content/uploads/2014/03/012.png" alt=""/>
<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NVCPW+APSWS2+2DVO+5YZ76"><span>【La PARLER(ラ・パルレ)】</span></a>
<p></p>
<span>33年間の実績とノウハウをもった、究極の男性エステサロン。</span>
<p></p>
<span>社内資格をもったスタッフが一生忘れることのできない体験を提供します。</span>
<p></p>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NVCPW+APSWS2+2DVO+5YZ76"><span>⇒公式サイトはこちら</span></a>';
}


function code_a7() {
return '<img onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” class="wp-temp-img-id" title="" src="http://estheticstaiken.com/wp-content/uploads/2014/03/012.png" alt=""/>【La PARLER(ラ・パルレ)】
<p></p>
<span>33年間の実績とノウハウをもった、究極の男性エステサロン。</span>
<p></p>
<span>社内資格をもったスタッフが一生忘れることのできない体験を提供します。</span>
<p></p>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NVCPW+APSWS2+2DVO+5YRHE"><span>⇒公式サイトはこちら</span></a>';
}


function code_a8() {
return '<img onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” class="wp-temp-img-id" title="" src="http://estheticstaiken.com/wp-content/uploads/2014/03/012.png" alt=""/>
<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NVCPW+APSWS2+2DVO+63WO1">【La PARLER(ラ・パルレ)】</a>
<p></p>
<span>33年間の実績とノウハウをもった、究極の男性エステサロン。</span>
<p></p>
<span>社内資格をもったスタッフが一生忘れることのできない体験を提供します。</span>
<p></p>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NVCPW+APSWS2+2DVO+63WO1"><span>⇒公式サイトはこちら</span></a>';
}

function code_a9() {
return '<a onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” href="https://px.a8.net/svt/ejp?a8mat=2NX5PG+DTQEIA+1MLG+4SSMWI"><img class="wp-temp-img-id" title="" src="https://www2.kobayashi.co.jp/upload/save_image/04281347_553f10eba4626.gif" alt="杜仲粒"/></a>

<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NX5PG+DTQEIA+1MLG+4SSMWI">【小林製薬のスリム杜仲粒】</a>
<p></p>
<p>基礎代謝を上げ、脂肪を燃焼する働きのあるアスペルロシドを小林製薬の25年の特殊技術で一粒に凝縮。</p>

<p>一日6粒で杜仲茶500mlの3.8本分、1時間のウォーキング効果があります。</p>

<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NX5PG+DTQEIA+1MLG+4SSMWI" target="_blank"><span>⇒小林製薬公式サイトはこちら</span></a>
<p></p>&nbsp;';
}

function code_a10() {
return '<img onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” class="wp-temp-img-id" title="" src="http://kintore-menu.com/wp-content/uploads/2016/09/%E3%82%AB%E3%83%A1%E3%83%A4%E3%83%9E%E9%85%B5%E6%AF%8D%E3%81%AE%E7%94%BB%E5%83%8F.jpg" alt=""/>
<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NX79T+49LUUQ+1WHU+HX5B6">【カメヤマ酵母】</a>
<p></p>
<p>12種類のビタミン、15種類のアミノ酸、ビフィズス菌、1トンもの野生植物から数百gしかとれない希少植物ミネラルを配合した究極の酵母。</p>
<p></p>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NX79T+49LUUQ+1WHU+HX5B6" target="_blank"><span>⇒カメヤマ酵母公式サイトはこちら</span></a>';
}


function code_a11() {
return ' <img onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” class="wp-temp-img-id" title="" src="http://www.thaiuiuc.org/img/bb.png" alt="nullbbクリーム"/>
<p>&nbsp;</p>
&nbsp;
<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NXBYN+E5N2LU+328C+ZQ80I">【NULL　BBクリーム】</a>
<p></p>
男性の肌の色、肌の質に特化して作られた男性専用のBBクリーム、コンシーラー。
<p></p>
美容成分が配合されており、肌への馴染み、使い易さが特徴で、初めてメンズコスメを使う男性に今一番選ばれています。
<p></p>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NXBYN+E5N2LU+328C+ZQ80I" target="_blank"><span>⇒商品詳細はこちら</span></a>';
}

function code_a12() {
return '<img onClick=”ga(‘send’,’event’,’affiliate’,’click’,’affiliate-img’,1,{‘nonInteraction’:1});” class="wp-temp-img-id" title="" src="http://b0nds.jp/wp-content/uploads/2016/11/2-8.jpg" alt=""/>
<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NXKK9+1KK78Y+3L60+5YJRM">【DCCディープチェンジクレアチン】</a>
<p></p>
<p>何よりも<strong>"絶大な体感"</strong>を感じたい人に一番選ばれているビルドアップサプリメント。トップビルダーも推奨しており、体感に満足いかない人には全額返金保障もある本気のサプリ。</p>
<p></p>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NXKK9+1KK78Y+3L60+5YJRM" target="_blank"><span>⇒DCCの詳細はこちら</span></a>';
}

function code_a13() {
return '<img class="wp-temp-img-id" title="" src="http://bulk-homme.com/img/starter-kit.jpg" alt=""/>
<a class="product" href="https://track.affiliate-b.com/visit.php?guid=ON&amp;a=u5711a-i245369C&amp;p=y5172126">【バルクオム】</a>
<p><p/>
<p>高級植物幹細胞を使用したメンズ専用スキンケアコスメ。</p>
<p><p/>
<p>本気でスキンケアを考えている方が使用する本格派コスメです。</p>
<p><p/>
<a class="button" href="https://track.affiliate-b.com/visit.php?guid=ON&amp;a=u5711a-i245369C&amp;p=y5172126" target="_blank"><span>公式サイトはこちら</span></a>';
}

function code_a14() {
return '<a href="https://px.a8.net/svt/ejp?a8mat=2NVF2N+48EZN6+26Z2+I8XOY" target="_blank"><img class="wp-temp-img-id " src="http://e-永久脱毛.jp/img/logo_mens-tbc.png" alt="メンズTBC"/></a>
<a class="product" href="https://px.a8.net/svt/ejp?a8mat=2NVF2N+48EZN6+26Z2+I8XOY">【MEN`S  TBC】</a>
<p><p/>
<p>40年間脱毛を研究し続け、脱毛では最も実績のあるメンズエステサロン。</p>
<p><p/>
<p>お客様のことを考え、脱毛のプロが1本1本丁寧に手作業で抜いていきます。</p>
<p><p/>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NVF2N+48EZN6+26Z2+I8XOY" target="_blank"><span>公式サイトはこちら</span></a>';
}

function code_a15() {
return '<a href="https://px.a8.net/svt/ejp?a8mat=2NVCPT+GC8AGI+1OGO+I708Y"><img id="wp-temp-img-id" class="alignleft" title="" src="http://www.dandy-house.co.jp/cm/images/pic_ad_02_2.jpg" alt="ダンディハウス" width="360" height="269" /></a>

<p><strong>【DANDY HOUSE】</strong></p>
<p></p>
<p>高級感のある上質な空間で受けるフェイシャルトリートメントはあなたに一生忘れられない体験をもたらしてくれます。</p>
<p></p>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2NVCPT+GC8AGI+1OGO+I708Y" target="_blank">⇒DANDY HOUSE公式HPはこちら</a>
<p></p>';
}

function code_a16() {
return '<a href="https://px.a8.net/svt/ejp?a8mat=2TAAL3+3E1VSI+3G9C+5YRHE"><img id="wp-temp-img-id" class="alignleft" title="" src="http://www.phil-quenum.com/img/2016-07-01_191427.gif" alt="防風通聖散" width="366" height="224" /></a>
<p><strong>【生漢煎 防風通聖散】</strong></p>
<p></p>
<p>脂肪燃焼に特化した18種類の漢方が腸内環境を改善し、脂肪の分解・燃焼・排出まで行ってくれます。</p>
<p></p>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2TAAL3+3E1VSI+3G9C+5YRHE" target="_blank">⇒防風通聖散公式サイトはこちら</a>';
}

function code_a17() {
return '<a href="https://track.affiliate-b.com/visit.php?guid=ON&a=W8490b-j285593A&p=y5172126"><img class="wp-image-25143 alignleft" src="http://www.healthy-style.jp/wp-content/uploads/761618bc1913037fe8677491cf5db398.jpg" alt="ジェントルフェイス" width="356" height="296" /></a>
<p></p>
<p>【GENTLE FACE】</p>
<p></p>
<p>自然由来の<strong>ノコギリヤシ</strong>や<strong>プラセンタ</strong>、<strong>マキベリー</strong>、<strong>ビタミンC</strong>によってニキビの原因である皮脂の過剰分泌を抑えることができる最新のスキンケアサプリ。</p>
<p>&nbsp;</p>
<a class="button" href="https://track.affiliate-b.com/visit.php?guid=ON&a=W8490b-j285593A&p=y5172126" target="_blank">⇒GENTLE FACE公式サイトはこちら<p></p></a>';
}

function code_a18() {
return '<a href="https://px.a8.net/svt/ejp?a8mat=2TC5Z2+9GJYSY+3NQS+5YRHE"><img id="wp-temp-img-id" class="alignleft" title="" src="http://www.wakiga-joshi.com/img/draroma.jpg" alt="ドクターアロマランス" width="349" height="349" /> 【ドクターアロマランス】</a>
<p></p>
<p>医療関係者がワキガ対策のために集結し、開発した医学部外品にも認定のされたワキガクリーム。</p>
<p>&nbsp;</p>
<p>完全無添加の天然由来の成分でワキ汗やワキの雑菌の増殖を抑えます。</p>
<p>&nbsp;</p>
<a class="button" href="https://px.a8.net/svt/ejp?a8mat=2TC5Z2+9GJYSY+3NQS+5YRHE" target="_blank">⇒ドクターアロマランスはこちら</a><p></p>';
}

function code_a19() {
return '<a href="http://www.medipartner.jp/click.php?APID=17747&amp;affID=0003627" target="_blank"><img class="alignnone wp-image-28722" src="http://www.healthy-style.jp/wp-content/uploads/S__42434568-1.jpg" alt="クリアネオ" width="353" height="331" /></a>
<p><p/>
<p>【クリアネオ】<p/>
<p><p/>
<p>厚生労働省認定の医学部外品に認定されている薬用のデオドラントクリームです。無添加処方で安心して使えながら、臭いの原因菌を99.999%殺菌します。満足行かなかった場合でも永久全額返金付きでリスクなく購入可能です。</p>
<p><p/>
<a class="button" href="http://www.medipartner.jp/click.php?APID=17747&amp;affID=0003627" target="_blank"><span>⇒公式サイトはこちらをクリック</span></a>';
}

function code_a20() {
return '<a href="http://www.medipartner.jp/click.php?APID=14275&amp;affID=0003627" target="_blank"><img class="alignnone wp-image-28645 size-full" src="http://www.healthy-style.jp/wp-content/uploads/92002253-F7AE-431C-BEAC-7812906FA7BE-e1489716671186.png" alt="クリアネオボディソープ" width="350" height="329" /></a>
<p><p/>
<p>【チャップアップシャンプー】<p/>
<p><p/>
毛髪診断士と美容師が開発したオーガニックノンシリコンシャンプーです。アミノ酸シャンプーにもなっており、抜け毛や育毛の妨げになる頭皮の硬化を和らげます。
<p><p/>
<a class="button" href="http://www.medipartner.jp/click.php?APID=14275&amp;affID=0003627" target="_blank"><span>⇒公式サイトはこちらをクリック</span></a>';
}

function code_a21() {
return '<a href="http://www.medipartner.jp/click.php?APID=12442&amp;affID=0003627" target="_blank"><img class="alignnone wp-image-28723" src="http://www.healthy-style.jp/wp-content/uploads/S__42434576.jpg" alt="クリアネオボディソープ" width="344" height="377" /></a>
<p><p/>
<p><strong>【クリアネオ ボディソープ】</strong><p/>
<p><p/>
<p>6種類の消臭成分と臭いの原因を抑制する柿渋エキスが配合されている、無添加処方のボディソープです。保湿成分も4種類配合されており、お風呂上がりもすべすべの肌を実感できます。<p/>
<p><p/>
<a class="button" href="http://www.medipartner.jp/click.php?APID=12442&amp;affID=0003627" target="_blank"><span>⇒公式サイトはこちらをクリック</span></a>';
}



add_shortcode('HotTabコード', 'code_a1');
add_shortcode('ネオテクトコード', 'code_a2');
add_shortcode('水素風呂コード', 'code_a3');
add_shortcode('柿渋石鹸コード', 'code_a4');
add_shortcode('メンズデオコード', 'code_a5');
add_shortcode('ラパルレダイエットコード', 'code_a6');
add_shortcode('ラパルレニキビコード', 'code_a7');
add_shortcode('ラパルレコード', 'code_a8');
add_shortcode('杜仲粒コード', 'code_a9');
add_shortcode('カメヤマコード', 'code_a10');
add_shortcode('BBコード', 'code_a11');
add_shortcode('DCCコード', 'code_a12');
add_shortcode('バルクオムコード', 'code_a13');
add_shortcode('TBCコード', 'code_a14');
add_shortcode('DANDY HOUSE', 'code_a15');
add_shortcode('生漢煎 防風通聖散', 'code_a16');
add_shortcode('GENTLE FACE', 'code_a17');
add_shortcode('ワキガクリーム', 'code_a18');
add_shortcode('クリアネオコード', 'code_a19');
add_shortcode('チャップアップシャンプーコード', 'code_a20');
add_shortcode('クリアネオボディソープコード', 'code_a21');


function my_custom_fields() {
  global $post;
  $keywords = get_post_meta($post->ID,'keywords',true);
  $description = get_post_meta($post->ID,'description',true);

  if ( !current_user_can('contributor')) {
  echo '<p>キーワード（半角カンマ区切り）<br>';
  echo '<input type="text" name="keywords" value="'.esc_html($keywords).'" size="40" placeholder="キーワードを入れてください" id="keywords_input"  /></p>';

  echo '<p>記事の説明 110~130文字以内 <br>';
  echo '<textarea type="text" name="description"  maxlength="130" onkeyup="ShowLength(this.value);" onload="ShowLength(this.value);" id="description_input" rows="3" cols="92"/ placeholder="記事の説明を入れてください">'.esc_html($description).'</textarea>
<span id="inputlength">文字数: '.mb_strlen($description).'</span></p>';
}else{
  echo '<p>キーワード（半角カンマ区切り）<br>';
  echo '<input type="text" readonly name="keywords" value="'.esc_html($keywords).'" size="40" placeholder="キーワードを入れてください" id="keywords_input"  /></p>';
  echo '<p>記事の説明 110~130文字以内 <br>';
  echo '<textarea type="text" readonly name="description"  maxlength="130" onkeyup="ShowLength(this.value);" onload="ShowLength(this.value);" id="description_input" rows="3" cols="92"/ placeholder="記事の説明を入れてください">'.esc_html($description).'</textarea>
<span id="inputlength">文字数: '.mb_strlen($description).'</span></p>';
}
}

// カスタムフィールドの値を保存
function save_custom_fields( $post_id ) {
  if(!empty($_POST['keywords'])){//ポストのキーワードが存在する
    if($_POST['keywords'] != null)update_post_meta($post_id, 'keywords', $_POST['keywords'] );//ポストのキーワードが空欄でなければ変更
  }
  if(!empty($_POST['description'])){//ポストのディスクリプションが存在する
    if($_POST['description'] != null)update_post_meta($post_id, 'description', $_POST['description'] );//ポストのディスクリプションが空欄でなければ変更
  }
}
add_action('admin_menu', 'add_custom_fields');
add_action('save_post', 'save_custom_fields');
add_action( 'edit_form_after_title', my_custom_fields );

function textCheckArert() {
  echo '<script>

      function textCheckAlert(){

          /****

          現在チェックポストが15個存在するので、それを繰り返し処理で
          一つずつチェックしていく
          ****/


          var checkIDName = "check_post_";
          for(var counter = 1; counter <=15; counter ++){
            var numToString = String(counter);
            var idName = checkIDName + numToString;
            var element = document.getElementById(idName);
            if(element.className == "check_ok"){

              element.style.backgroundColor = "LightGreen";
            }else{
              element.style.backgroundColor = "Salmon";
            }

          }
      }

  </script>'.PHP_EOL;
}
add_action('admin_print_scripts-post.php', 'textCheckArert');
add_action('admin_print_scripts-post-new.php', 'textCheckArert');

//現在のページ数の取得
function show_page_number() {
    global $wp_query;

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $max_page = $wp_query->max_num_pages;
    echo $paged;
}

//総ページ数の取得
function max_show_page_number() {
    global $wp_query;

    $max_page = $wp_query->max_num_pages;
    echo $max_page;
}

function get_meta_description() {
  global $post;
  $description = "";
  if ( is_home() ) {
    // ホームでは、ブログの説明文を取得
    $description = get_bloginfo( 'description' );
  }
  elseif ( is_category() ) {
    // カテゴリーページでは、カテゴリーの説明文を取得
    $description = category_description();
  }
  elseif ( is_single() ) {
    if ($post->post_excerpt) {
      // 記事ページでは、記事本文から抜粋を取得
      $description = $post->post_excerpt;
    } else {
      // post_excerpt で取れない時は、自力で記事の冒頭100文字を抜粋して取得
      $description = strip_tags($post->post_content);
      $description = str_replace("\n", "", $description);
      $description = str_replace("\r", "", $description);
      $description = mb_substr($description, 0, 100) . "...";
    }
  } else {
    ;
  }

  return $description;
}

// 人気記事出力用
function getPostViews($postID){
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0 View";
	}
	return $count.' Views';
}
function setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
	}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
	}
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);



?>
