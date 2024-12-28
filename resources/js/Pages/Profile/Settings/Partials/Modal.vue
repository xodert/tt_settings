<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
    <div class="bg-white rounded-lg shadow-lg w-full sm:w-1/2 ">
      <header class="px-4 py-2 border-b">
        <h2 class="text-lg font-semibold">
          <slot name="title"></slot>
        </h2>
      </header>
      <main class="p-4">
        <slot name="body"></slot>
      </main>
      <footer class="px-4 py-2 border-t flex justify-end">
        <slot name="footer"></slot>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  name: "Modal",
  emits: ["close"]
};
</script>

<style scoped></style>
