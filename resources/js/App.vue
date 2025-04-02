<template>
    <div class="app-wrapper text-white min-vh-100">
      <nav class="p-3">
        <router-link class="btn btn-outline-light me-2" to="/">Каталог</router-link>
        <router-link class="btn btn-outline-light me-2" to="/cart">Корзина</router-link>
        <router-link class="btn btn-outline-light me-2" to="/inventory">Инвентарь</router-link>
        <router-link class="btn btn-outline-light" to="/login">Вход</router-link>
      </nav>
  
      <div class="container py-4">
        <router-view />
      </div>
    </div>
  </template>
  
  <style>
  .app-wrapper {
    background-color: #171a21; /* тёмно-синий как у Steam */
    min-height: 100vh;
  }
  </style>
  