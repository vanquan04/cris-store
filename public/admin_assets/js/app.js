$(document).ready(function () {
    $(".nav-link.active .sub-menu").slideDown();

    $("#sidebar-menu .arrow").click(function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(":checked");
        $(".table-checkall tbody tr td input:checkbox").prop(
            "checked",
            checked
        );
    });
});

var inputFile = document.querySelector("#file_upload");
function chooseFile(fileInput) {
    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#image").attr("src", e.target.result);
        };
        reader.readAsDataURL(fileInput.files[0]);
    }
}

function ChangeToSlug(str) {
    var slug = str.toLowerCase();

    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, "a");
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, "e");
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, "i");
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, "o");
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, "u");
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, "y");
    slug = slug.replace(/đ/gi, "d");
    slug = slug.replace(
        /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi,
        ""
    );
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, "-");
    slug = slug.replace(/\-\-\-\-/gi, "-");
    slug = slug.replace(/\-\-\-/gi, "-");
    slug = slug.replace(/\-\-/gi, "-");
    slug = "@" + slug + "@";
    slug = slug.replace(/\@\-|\-\@|\@/gi, "");
    return slug;
}

$(document).ready(function () {
    $(".autofill-trigger").click(function () {
        var nameValue = $("#name").val();
        $("#slug").val(ChangeToSlug(nameValue));
    });
});

var inputFile = document.querySelector(".img");
const fileUpload = document.getElementById("file-uploads");
if (fileUpload) {
    fileUpload.addEventListener("change", (event) => {
        const files = event.target.files;
        var str = "";
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var url = URL.createObjectURL(file);
            str +=
                "<span><img class = 'img m-2' src='" +
                url +
                "' width='110' height='110' class='img' </span>";
        }
        var blockImages = document.getElementById("images");
        if (blockImages) {
            blockImages.innerHTML = str;
        }
    });
}

function count() {
    var price = document.getElementById("old_price").value;
    var discount = document.getElementById("discount").value;
    var new_price1 = (price * discount) / 100;
    var new_price = price - new_price1;
    if (discount > 100) {
        alert("Không thể giảm giá vượt quá 100% giá trị sản phẩm");
    } else {
        document.getElementById("new_price").value = new_price;
    }
}

function url(link) {
    return "https://quy.unitopcv.com/Project/TQStore/public/" + link;
}
