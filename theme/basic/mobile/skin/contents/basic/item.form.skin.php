<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MCONTENTS_CSS_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL ?>/contents.mobile.js"></script>

<form name="fitem" method="post" action="<?php echo $action_url; ?>" onsubmit="return fitem_submit(this);">
<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">

<div id="cit_ov_wrap">
    <!-- 상품이미지 미리보기 시작 { -->
    <div id="cit_pvi">
        <div id="cit_pvi_big">
        <?php
        $big_img_count = 0;
        $thumbnails = array();
        for($i=1; $i<=10; $i++) {
            if(!$it['it_img'.$i])
                continue;

            $img = cm_get_it_thumbnail($it['it_img'.$i], 300, 300);

            if($img) {
                $big_img_count++;

                echo '<a href="'.G5_CONTENTS_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$i.'" target="_blank" class="popup_item_image">'.$img.'</a>';
            }
        }

        if($big_img_count == 0) {
            echo '<img src="'.G5_CONTENTS_URL.'/img/no_image.gif" alt="">';
        }
        ?>
        </div>
    </div>
    <!-- } 상품이미지 미리보기 끝 -->

    <!-- 상품 요약정보 및 구매 시작 { -->
    <section id="cit_ov">
        <h2 id="cit_title"><?php echo stripslashes($it['it_name']); ?> <span class="sound_only">요약정보 및 구매</span></h2>
        <?php if($is_orderable) { ?>
        <p id="cit_opt_info">
            상품 선택옵션 <?php echo $option_count; ?> 개
        </p>
        <?php } ?>
        <div id="cit_star_sns">
            <?php if ($star_score) { ?>
            고객평점 <span>별<?php echo $star_score?>개</span>
            <img src="<?php echo G5_CONTENTS_URL; ?>/img/s_star<?php echo $star_score?>.png" alt="" class="sit_star">
            <?php } ?>
            <?php echo $sns_share_links; ?>
        </div>
        <table class="cit_ov_tbl">
        <colgroup>
            <col class="grid_3">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th>상품코드</th>
            <td><?php echo get_text($it['it_id']); ?></td>
        </tr>
        <?php
        for($i=1; $i<=5; $i++) {
            if(!$it['it_info'.$i.'_subj'] || !$it['it_info'.$i])
                continue;
        ?>
        <tr>
            <th scope="row"><?php echo get_text($it['it_info'.$i.'_subj']); ?></th>
            <td><?php echo get_text($it['it_info'.$i]); ?></td>
        </tr>
        <?php
        }
        ?>
        <?php if($it['it_user_demo'] || $it['it_admin_demo']) { ?>
        <tr>
            <th>샘플보기</th>
            <td>
                <?php if($it['it_user_demo']) { ?>
                <a href="<?php echo set_http($it['it_user_demo']); ?>" class="cit_ov_tbl_btn" target="_blank">샘플사이트</a>
                <?php } ?>
                <?php if($it['it_admin_demo']) { ?>
                <a href="<?php echo set_http($it['it_admin_demo']); ?>" class="cit_ov_tbl_btn" id="adm" target="_blank">관리자사이트</a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </section>
    <!-- } 상품 요약정보 및 구매 끝 -->

        <?php if($option_item) { ?>
        <div id="cit_opt">
            <table>
            <thead>
            <tr>
                <th class="tbl_opt" colspan="2">옵션
                    <label for="chk_opt_all" class="sound_only">옵션 전체 선택</label>
                    <input type="checkbox" name="chk_opt_all" id="chk_opt_all">
                </th>
            </tr>
            <tr>
                <th class="tbl_qty">수량</th>
                <th class="tbl_pri">판매가</th>
            </tr>
            </thead>
            <tbody>
            <?php echo $option_item; ?>
            </tbody>
            </table>
        </div>
        <div id="cit_opt_prc">
            총 금액 <span>0원</span>
        </div>
        <?php } ?>

        <div id="cit_ov_btnlst">
            <?php if ($is_orderable) { ?>
            <input type="submit" onclick="document.pressed=this.value;" value="바로구매" id="cit_btn_buy">
            <input type="submit" onclick="document.pressed=this.value;" value="장바구니" id="cit_btn_cart">
            <?php } ?>
            <a href="javascript:item_wish(document.fitem, '<?php echo $it['it_id']; ?>');" id="cit_btn_wish">찜하기</a>
        </div>

        <script>
        // 상품보관
        function item_wish(f, it_id)
        {
            f.url.value = "<?php echo G5_CONTENTS_URL; ?>/wishupdate.php?it_id="+it_id;
            f.action = "<?php echo G5_CONTENTS_URL; ?>/wishupdate.php";
            f.submit();
        }

        // 추천메일
        function popup_item_recommend(it_id)
        {
            if (!g5_is_member)
            {
                if (confirm("회원만 추천하실 수 있습니다."))
                    document.location.href = "<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo urlencode(G5_CONTENTS_URL."/item.php?it_id=$it_id"); ?>";
            }
            else
            {
                url = "./itemrecommend.php?it_id=" + it_id;
                opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
                popup_window(url, "itemrecommend", opt);
            }
        }
        </script>
</div>

<?php
$href = G5_CONTENTS_URL.'/iteminfo.php?it_id='.$it_id;
?>
<div id="sit_more">
    <ul class="sanchor">
        <li><a href="<?php echo $href; ?>" target="_blank">상품정보</a></li>
        <li><a href="<?php echo $href; ?>&amp;info=use" target="_blank">사용후기 <span class="item_use_count"><?php echo $item_use_count; ?></span></a></li>
        <li><a href="<?php echo $href; ?>&amp;info=qa" target="_blank">상품문의 <span class="item_qa_count"><?php echo $item_qa_count; ?></span></a></li>
        <?php if($setting['de_mobile_rel_list_use']) {?>
        <li><a href="<?php echo $href; ?>&amp;info=rel" target="_blank">관련상품 <span class="item_relation_count"><?php echo $item_relation_count; ?></span></a></li>
        <?php } ?>
    </ul>
</div>
</form>


<script>
$(function(){
    // 상품이미지 첫번째 링크
    $("#cit_pvi_big a:first").addClass("visible");

    var $pvi_img = $("#cit_pvi_big").find("a.popup_item_image");
    var pvi_img_count = $pvi_img.size();

    if(pvi_img_count > 1) {
        var pvi_btn = "<button type=\"button\" class=\"big_img_chg pvi_pre\">이전</button>\n";
        pvi_btn += "<button type=\"button\" class=\"big_img_chg pvi_next\">다음</button>\n";

        $("#cit_pvi_big").after(pvi_btn);
    }

    $("#cit_pvi button.big_img_chg").on("click", function() {
        var txt = $(this).text();
        var c_idx = $pvi_img.index($pvi_img.filter(":visible"));
        var n_idx = 0;

        if(txt == "이전") {
            n_idx = c_idx - 1;

            $pvi_img.eq(c_idx).css("display", "none");
            $pvi_img.eq(n_idx).css("display", "block");
        } else {
            n_idx = (c_idx + 1) % pvi_img_count;

            $pvi_img.eq(c_idx).css("display", "none");
            $pvi_img.eq(n_idx).css("display", "block");
        }
    });

    // 상품이미지 크게보기
    $(".popup_item_image").click(function() {
        var url = $(this).attr("href");
        var top = 10;
        var left = 10;
        var opt = 'scrollbars=yes,top='+top+',left='+left;
        popup_window(url, "largeimage", opt);

        return false;
    });
});
</script>

