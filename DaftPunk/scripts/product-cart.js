let cart = [];

function setCookie(name, value, days) {
  const date = new Date();
  date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000); 
  document.cookie = `${name}=${encodeURIComponent(value)};expires=${date.toUTCString()};path=/`;
}

function getCookie(name) {
  const cookieArray = document.cookie.split('; ');
  for (const cookie of cookieArray) {
    const [key, value] = cookie.split('=');
    if (key === name) return decodeURIComponent(value);
  }
  return null;
}

function deleteCookie(name) {
  document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/`;
}

function saveCartToCookies() {
  setCookie('cart', JSON.stringify(cart), 365); 
}

function loadCartFromCookies() {
  const cartData = getCookie('cart');
  if (cartData) {
    cart = JSON.parse(cartData);
  }
}

function addToCart(name, price) {
  cart.push({ name, price });
  saveCartToCookies();
  updateCartUI();
}

function updateCartUI() {
  const cartCount = document.getElementById('cart-count');
  const cartItems = document.getElementById('cart-items');
  const cartTotal = document.getElementById('cart-total');

  cartCount.textContent = cart.length;

  let total = 0;
  cartItems.innerHTML = ''; 

  cart.forEach(item => {
    const listItem = document.createElement('li');
    listItem.innerHTML = `${item.name} - £${item.price.toFixed(2)}`;
    cartItems.appendChild(listItem);
    total += item.price;
  });

  cartTotal.textContent = `Total: £${total.toFixed(2)}`;
}

function clearCart() {
  cart = [];
  saveCartToCookies();
  updateCartUI();
}

function checkout() {
  if (cart.length === 0) {
    alert("Your cart is empty! Please add some items to your cart before proceeding.");
  } else {
    window.location.href = '../pages/checkout.php'; 
  }
}

function closeCart() {
  document.getElementById('cart-modal').style.display = 'none';
}

document.getElementById('cart-btn').addEventListener('click', () => {
  const cartButton = document.getElementById('cart-btn');
  const cartModal = document.getElementById('cart-modal');
  const buttonRect = cartButton.getBoundingClientRect();

  cartModal.style.position = 'absolute';
  cartModal.style.top = `${buttonRect.bottom + window.scrollY}px`; 
  cartModal.style.left = `${buttonRect.left + window.scrollX - 70}px`; 
  cartModal.style.display = 'block'; 
  cartModal.style.backgroundColor = '#d13131';
  cartModal.style.color = '#ffffff'; 
  cartModal.style.padding = '10px'; 
  cartModal.style.borderRadius = '8px'; 
  cartModal.style.boxShadow = '0 0 15px rgba(0, 0, 0, 0.2)'; 
});

document.getElementById('close-cart-btn').addEventListener('click', closeCart);
document.getElementById('checkout-btn').addEventListener('click', checkout);

window.addEventListener('DOMContentLoaded', () => {
  loadCartFromCookies();
  updateCartUI();
});
