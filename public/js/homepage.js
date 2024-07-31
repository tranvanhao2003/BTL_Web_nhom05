//slideshow

let slideIndex = 0;
// let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides((slideIndex += n));
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides((slideIndex = n));
}
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }
  slides[slideIndex - 1].style.display = "block";
  setTimeout(showSlides, 5000);
}

//side navigation
function openNav() {
  document.getElementById("cartDrawer").style.width = "400px";
  document.body.style.backgroundColor = "rgba(0,0,0,0)";
  // fix
}

function closeNav() {
  document.getElementById("cartDrawer").style.width = "0";
  document.body.style.backgroundColor = "white";
}

//btn function
$(".btn-cong, .btn-tru").on("click", function () {
  var type = $(this).attr("data-type");
  console.log(type);
  var parent = $(this).parent();
  var input_solg = parent.find(".input_solg");
  var solg = input_solg.val();
  if (type == "cong") {
    solg = parseInt(solg) + 1;
  } else {
    if (solg > 1) {
      solg = parseInt(solg) - 1;
    }
  }

  input_solg.val(solg);

  var price = input_solg.attr("data-price");
  var total = solg * price;

  //selector ra đối tượng cha bất kì parents
  var parents = $(this).parents(".action");
  parents.find("#total").text(formatPrice(total) + "đ");
  var total = totalPrice();
  $("#total").text(formatPrice(total) + "đ");
});

$(".btn-xoa").on("click", function () {
  $(this).parents(".row").remove();
  var total = totalPrice();
  $("#total").text(formatPrice(total) + "đ");
});

function formatPrice(total) {
  return total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
}

function totalPrice() {
  var total = 0;
  $(".solg_sp").each(function () {
    var solg = $(this).find(".input_solg").val();
    var price = $(this).find(".input_solg").attr("data-price");
    console.log(price);
    var total_1sp = solg * price;
    total = total + parseInt(total_1sp);
  });
  return total;
}
