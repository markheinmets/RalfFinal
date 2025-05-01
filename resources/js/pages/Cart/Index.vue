<template>
  <div>
    <h1>Your Cart</h1>
    <div v-if="cart && Object.keys(cart).length">
      <div v-for="(item, productId) in cart" :key="productId">
        <div>{{ item.name }}</div>
        <div>{{ item.quantity }} x ${{ item.price }}</div>
        <button @click="removeFromCart(productId)">Remove</button>
      </div>
      <button @click="goToCheckout">Go to Checkout</button>
    </div>
    <div v-else>
      <p>Your cart is empty</p>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const { cart } = usePage().props;

const removeFromCart = (productId) => {
  axios.delete(route('cart.remove', productId))
    .then(response => {
      // Handle success
    })
    .catch(error => {
      // Handle error
    });
};

const goToCheckout = () => {
  window.location.href = route('checkout.index');
};
</script>

<style scoped>
/* Your styles here */
</style>
