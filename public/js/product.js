//scroll to top
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

//lazy load
// window.addEventListener("DOMContentLoaded", () => {
//   const images = document.querySelectorAll("img")
//   images.forEach(image) => {
//     new IntersectionObserver((entries, observe) => {
//       entries.forEach(entry => {
//         if (entry.isIntersecting) {
//           const img = entry.target
//           const dataSrc = img.getAttribute("data-src")
//           img.getAttribute("src," dataSrc)
//           img.removeAttribute("data-src")
//           observe.disconnect
//         }
//       })
//     })
//   }
// })

//CartDrawer
function openNav() {
  document.getElementById("cartDrawer").style.width = "400px";
  document.body.style.backgroundColor = "rgba(0,0,0,0)";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("cartDrawer").style.width = "0";
  document.body.style.backgroundColor = "white";
}

//btn function
$(".btn-cong2, .btn-tru2").on("click", function(){
  var type = $(this).attr("data-type");
  console.log(type)
  var parent = $(this).parent();
  var input_solg = parent.find(".input_solg2");
  var solg = input_solg.val();
  if (type == "cong"){
      solg = parseInt(solg) + 1;
  }else{
      if (solg > 1){
          solg = parseInt(solg) - 1; 
      }
  }
  
  input_solg.val(solg);

  var price = input_solg.attr("data-price");
  var total = solg * price;

  //selector ra đối tượng cha bất kì parents
  var parents = $(this).parents(".action");
  parents.find("#total2").text(formatPrice(total2)+"đ");
  var total = totalPrice()
  $("#total2").text(formatPrice(total)+ "đ")

})


$(".btn-xoa2").on("click", function(){
  $(this).parents(".row2").remove();
  var total = totalPrice()
  $("#total2").text(formatPrice(total)+ "đ")
})

function formatPrice(total){
  return total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
}

function totalPrice(){
  var total = 0
  $(".solg_sp2").each(function(){
      var solg = $(this).find(".input_solg2").val()
      var price = $(this).find(".input_solg2").attr("data-price")
      console.log(price)
      var total_1sp = solg * price
      total = total + parseInt(total_1sp)
  })
  return total
}