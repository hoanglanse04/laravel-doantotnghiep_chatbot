//Check URL
var protocol = window.location.protocol;
var hostname = window.location.hostname;
var url = protocol+'//'+hostname+'/';


$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
/******************************
 ************ADD CART**********
 ******************************
 * onclick="add_cart(this)" data-product-id=""
 ******************************/
function add_cart(even){
  let quantity = 1
  let exists_quantity = document.getElementById("number")
  let modal = document.getElementById('modal-alert-cart')
  let cartQuantity = document.querySelectorAll('.total-cart')
  if(exists_quantity != null){
    quantity = exists_quantity.value
  }
  $.ajax({
      type: "post",
      url: url+"cart/add",
      data: {
          product_id: even.getAttribute('data-product-id'),
          quantity: quantity
      },
      success: function (response) {
        modal.classList.remove('hidden');
          for (let i = 0; i < cartQuantity.length; i++) {
            const element = cartQuantity[i];
            element.innerHTML = response.total_cart;
          }
          setTimeout(function(){
            modal.classList.add('hidden');
          }, 3000);
      }
  });
}

/******************************
 ******FAVORITE PRODUCT********
 ******************************
 * onclick="add_favorite(this)" data-product-id=""
 ******************************/
function add_favorite(even){
  var product_id = even.getAttribute('data-product-id');
  $.ajax({
    type: "post",
    url: url+"san-pham/favorite",
    data: {
      'product_id': product_id
    },
    success: function (response) {
      if(response.status == 1){
        if(response.favorite == 1){
          if(document.querySelector('.favorite') != null) {
            document.querySelector('.favorite').innerHTML = '<svg viewBox="0 0 512 512"><path fill="currentColor" d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z"></path></svg>';
            swal("Tuyệt vời!", response.message);
          } else if (even.getAttribute('class') == 'inner inner-favorite'){
            even.style.backgroundColor = '#c77531';
            even.style.color = '#fff';
            swal("Tuyệt vời!", response.message);
          } else {
            swal("Tuyệt vời!", response.message);
          }
        } else {
          if(document.querySelector('.favorite') != null) {
            document.querySelector('.favorite').innerHTML = '<svg viewBox="0 0 512 512"><path fill="currentColor" d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"></path></svg>';
          } else if (even.getAttribute('class') == 'inner inner-favorite'){
            even.style.backgroundColor = '';
            even.style.color = '#333';
          }
        }
      } else {
        swal("Ooop! " + response.message, {
          icon: "info",
        });
      }
    }
  })
}

/**************************************
 * Cart Handle
 * - Cart Order
 * - Handles basket numbers, totals and prices
 **************************************/
//-Cart Order
var buttonCartOrder = document.getElementById('js_cart_order');
if(buttonCartOrder != null){
  buttonCartOrder.addEventListener('click',Order);
}
function Order(){
  var email         = document.getElementById('input_email').value;
  var full_name     = document.getElementById('input_full_name').value;
  var number_phone  = document.getElementById('input_number_phone').value;
  var location      = document.getElementById('input_location').value;
  var province      = document.getElementById('province').value;
  var district      = document.getElementById('district').value;
  var ward          = document.getElementById('ward').value;
  var note          = document.getElementById('input_note').value;
  //if error validate input
  var status_message          = document.getElementById('status_message');
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  //just take user location
  $.ajax({
      type: "post",
      url: "cart/order",
      data: {
          'email': email,
          'full_name':  full_name,
          'number_phone': number_phone,
          'location': location,
          'province': province,
          'district': district,
          'ward': ward,
          'note': note
      },
      success: function (response) {
        status_message.innerHTML = response.status;
        console.log(response.status);
      },
      error: function(response) {
        console.log(response.status);
      }
  });
}
//-Handles basket numbers, totals and prices
if (document.readyState == 'loading') {
  document.addEventListener('DOMContentLoaded', Cartready)
} else {
  Cartready()
}
//CART READY
function Cartready() {
  var quantityInputs = document.getElementsByClassName('cart-quantity-input')
  for (var i = 0; i < quantityInputs.length; i++) {
      var input = quantityInputs[i]
      input.addEventListener('change', quantityChanged)
  }
}
function updateCartTotal() {
  var cartItemContainer = document.getElementsByClassName('cart-items')[0]
  var cartRows = cartItemContainer.getElementsByClassName('cart-row')
  var total = 0
  var quantityN = 0
  for (var i = 0; i < cartRows.length; i++) {
      var cartRow = cartRows[i]
      var priceElement = cartRow.getElementsByClassName('cart-price')[0]
      var cartPriceItem = cartRow.getElementsByClassName('cart-price-item')[0]
      var quantityElement = cartRow.getElementsByClassName('cart-quantity-input')[0]

      var price = priceElement.innerText
      var replaceAllPrice = price.replaceAll('.','')

      var quantity = quantityElement.value
      total = total + (replaceAllPrice * quantity)
      quantityN = parseFloat(quantityN + Number(quantity))
      //Format price item
      cartPriceItemFormat = replaceAllPrice * Number(quantity)
      cartPriceItem.innerText = new Intl.NumberFormat('vi').format(cartPriceItemFormat)
  }
  total = Math.round(total)
  document.getElementsByClassName('cart-total-price')[0].innerText = new Intl.NumberFormat('vi').format(total)
  document.getElementsByClassName('cart-total-quantity')[0].innerText = quantityN
}
//UPDATE Quantity Cart handmade PC
function quantityChanged(event) {
  var input = event.target
  if (isNaN(input.value) || input.value <= 0) {
      input.value = 1
  }
  var quantity = input.value
  var product_id = input.getAttribute('data-productid')
  updateCart(product_id,quantity)
  updateCartTotal()
}

function updateCart(productId,quantity){
  $.ajax({
      type: "post",
      url: "cart/update",
      data: {
          'product_id': productId,
          'quantity':  quantity
      },
      success: function (response) {
          console.log(response.status)
      }
  });
}
if(document.querySelector('.close-modal') != null){
  document.querySelector('.close-modal').addEventListener('click', function(){
    document.getElementById('modal-alert-cart').classList.add('hidden');
  })
}