<script setup>
import { ref } from 'vue'
import { RouterView } from 'vue-router'

const isConnected = ref(false)
const btnLogout = ref(false)
const countSentry = ref(0)
const countSmtp = ref(0)
const countLog = ref(0)
const countDump = ref(0)

</script>

<template>
  <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
          <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
          </button>
          <a href="/" class="flex ms-2 md:me-24">
            <svg class="h-8 me-4" viewBox="0 0 113.21 96.291" xmlns="http://www.w3.org/2000/svg"><g id="svgGroup" stroke-linecap="round" fill-rule="evenodd" font-size="9pt" stroke="#3375c7" stroke-width="0.2mm" fill="#3375c7" style="stroke:#3375c7;stroke-width:0.2mm;fill:#3375c7"><path d="M 35.487 94.285 A 11.226 11.226 0 0 0 39.001 95.869 A 15.07 15.07 0 0 0 40.291 96.134 Q 41.276 96.29 42.196 96.29 A 8.802 8.802 0 0 0 48.251 94.019 A 14.043 14.043 0 0 0 48.522 93.77 Q 51.957 90.547 53.401 84.869 A 68.416 68.416 0 0 0 53.771 83.374 Q 54.29 81.167 54.596 79.173 A 37.612 37.612 0 0 0 55.001 75.269 A 74.356 74.356 0 0 0 55.01 75.059 Q 55.102 73.018 55.074 71.108 A 54.638 54.638 0 0 0 54.901 67.419 Q 54.601 63.769 54.701 59.869 A 26.701 26.701 0 0 1 54.727 59.176 Q 54.915 55.547 56.101 51.169 A 46.639 46.639 0 0 1 57.388 46.975 A 57.282 57.282 0 0 1 60.101 40.669 Q 62.801 35.269 65.651 29.319 Q 68.501 23.369 70.001 16.869 A 31.11 31.11 0 0 0 70.555 14.262 Q 70.967 11.792 70.901 9.519 A 13.613 13.613 0 0 0 70.655 7.265 A 10.234 10.234 0 0 0 69.201 3.619 A 7.004 7.004 0 0 0 66.371 1.157 A 10.271 10.271 0 0 0 64.101 0.369 Q 58.801 -0.931 55.451 2.369 A 16.561 16.561 0 0 0 52.442 6.439 A 21.168 21.168 0 0 0 50.701 10.969 Q 49.001 17.569 48.351 24.269 Q 47.701 30.969 47.201 37.119 Q 46.701 43.269 45.401 48.369 A 51.552 51.552 0 0 1 45.052 49.689 Q 43.955 53.633 42.451 56.469 Q 40.701 59.769 38.801 62.769 A 70.437 70.437 0 0 0 37.324 65.212 A 87.204 87.204 0 0 0 35.051 69.419 A 30.61 30.61 0 0 0 34.208 71.231 Q 33.527 72.826 32.914 74.704 A 60.862 60.862 0 0 0 31.801 78.569 A 26.845 26.845 0 0 0 31.286 81.134 Q 30.943 83.44 31.093 85.507 A 14.85 14.85 0 0 0 32.001 89.719 A 9.485 9.485 0 0 0 35.487 94.285 Z M 77.787 94.285 A 11.226 11.226 0 0 0 81.301 95.869 A 15.07 15.07 0 0 0 82.591 96.134 Q 83.576 96.29 84.496 96.29 A 8.802 8.802 0 0 0 90.551 94.019 A 14.043 14.043 0 0 0 90.822 93.77 Q 94.257 90.547 95.701 84.869 A 68.416 68.416 0 0 0 96.071 83.374 Q 96.59 81.167 96.896 79.173 A 37.612 37.612 0 0 0 97.301 75.269 A 74.356 74.356 0 0 0 97.31 75.059 Q 97.402 73.018 97.374 71.108 A 54.638 54.638 0 0 0 97.201 67.419 Q 96.901 63.769 97.001 59.869 A 26.701 26.701 0 0 1 97.027 59.176 Q 97.215 55.547 98.401 51.169 A 46.639 46.639 0 0 1 99.688 46.975 A 57.282 57.282 0 0 1 102.401 40.669 Q 105.101 35.269 107.951 29.319 Q 110.801 23.369 112.301 16.869 A 31.11 31.11 0 0 0 112.855 14.262 Q 113.267 11.792 113.201 9.519 A 13.613 13.613 0 0 0 112.955 7.265 A 10.234 10.234 0 0 0 111.501 3.619 A 7.004 7.004 0 0 0 108.671 1.157 A 10.271 10.271 0 0 0 106.401 0.369 Q 101.101 -0.931 97.751 2.369 A 16.561 16.561 0 0 0 94.742 6.439 A 21.168 21.168 0 0 0 93.001 10.969 Q 91.301 17.569 90.651 24.269 Q 90.001 30.969 89.501 37.119 Q 89.001 43.269 87.701 48.369 A 51.552 51.552 0 0 1 87.352 49.689 Q 86.255 53.633 84.751 56.469 Q 83.001 59.769 81.101 62.769 A 70.437 70.437 0 0 0 79.624 65.212 A 87.204 87.204 0 0 0 77.351 69.419 A 30.61 30.61 0 0 0 76.508 71.231 Q 75.827 72.826 75.214 74.704 A 60.862 60.862 0 0 0 74.101 78.569 A 26.845 26.845 0 0 0 73.586 81.134 Q 73.243 83.44 73.393 85.507 A 14.85 14.85 0 0 0 74.301 89.719 A 9.485 9.485 0 0 0 77.787 94.285 Z M 0.553 63.892 A 13.648 13.648 0 0 0 0.001 67.869 Q 0.001 73.069 3.301 76.219 A 10.162 10.162 0 0 0 4.694 77.332 Q 7.757 79.369 12.501 79.369 A 20.341 20.341 0 0 0 13.066 79.361 Q 15.024 79.306 16.672 78.87 A 10.459 10.459 0 0 0 21.501 76.169 A 10.494 10.494 0 0 0 24.212 71.526 A 13.762 13.762 0 0 0 24.701 67.769 A 15.207 15.207 0 0 0 24.564 65.7 A 10.902 10.902 0 0 0 21.401 59.219 A 10.891 10.891 0 0 0 16.303 56.407 A 15.6 15.6 0 0 0 12.501 55.969 A 16.568 16.568 0 0 0 8.803 56.359 A 11.123 11.123 0 0 0 3.351 59.269 A 10.788 10.788 0 0 0 0.553 63.892 Z M 3.301 38.419 A 10.162 10.162 0 0 0 4.694 39.532 Q 7.757 41.569 12.501 41.569 A 20.341 20.341 0 0 0 13.066 41.561 Q 15.024 41.506 16.672 41.07 A 10.459 10.459 0 0 0 21.501 38.369 A 10.494 10.494 0 0 0 24.212 33.726 A 13.762 13.762 0 0 0 24.701 29.969 A 15.207 15.207 0 0 0 24.564 27.9 A 10.902 10.902 0 0 0 21.401 21.419 A 10.891 10.891 0 0 0 16.303 18.607 A 15.6 15.6 0 0 0 12.501 18.169 A 16.568 16.568 0 0 0 8.803 18.559 A 11.123 11.123 0 0 0 3.351 21.469 A 10.788 10.788 0 0 0 0.553 26.092 A 13.648 13.648 0 0 0 0.001 30.069 Q 0.001 35.269 3.301 38.419 Z" vector-effect="non-scaling-stroke"/></g></svg>
            <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">trackflow</span>
          </a>
        </div>
        <div class="flex items-center" >
          <div class="flex items-center ms-3">
            <a href="https://github.com/trackflow/server" target="_blank" class="mr-3"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M12.006 2a9.847 9.847 0 0 0-6.484 2.44 10.32 10.32 0 0 0-3.393 6.17 10.48 10.48 0 0 0 1.317 6.955 10.045 10.045 0 0 0 5.4 4.418c.504.095.683-.223.683-.494 0-.245-.01-1.052-.014-1.908-2.78.62-3.366-1.21-3.366-1.21a2.711 2.711 0 0 0-1.11-1.5c-.907-.637.07-.621.07-.621.317.044.62.163.885.346.266.183.487.426.647.71.135.253.318.476.538.655a2.079 2.079 0 0 0 2.37.196c.045-.52.27-1.006.635-1.37-2.219-.259-4.554-1.138-4.554-5.07a4.022 4.022 0 0 1 1.031-2.75 3.77 3.77 0 0 1 .096-2.713s.839-.275 2.749 1.05a9.26 9.26 0 0 1 5.004 0c1.906-1.325 2.74-1.05 2.74-1.05.37.858.406 1.828.101 2.713a4.017 4.017 0 0 1 1.029 2.75c0 3.939-2.339 4.805-4.564 5.058a2.471 2.471 0 0 1 .679 1.897c0 1.372-.012 2.477-.012 2.814 0 .272.18.592.687.492a10.05 10.05 0 0 0 5.388-4.421 10.473 10.473 0 0 0 1.313-6.948 10.32 10.32 0 0 0-3.39-6.165A9.847 9.847 0 0 0 12.007 2Z" clip-rule="evenodd"/>
            </svg></a>
            <svg data-tooltip-target="tooltip-bottom" data-tooltip-placement="bottom" v-if="isConnected" class="animate-pulse w-6 h-6 text-gray-800 dark:text-white" fill="currentColor" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 365.892 365.892" xml:space="preserve">
                            <g>
                                <circle cx="182.945" cy="286.681" r="41.494"/>
                              <path d="M182.946,176.029c-35.658,0-69.337,17.345-90.09,46.398c-5.921,8.288-4.001,19.806,4.286,25.726
                                    c3.249,2.321,6.994,3.438,10.704,3.438c5.754,0,11.423-2.686,15.021-7.724c13.846-19.383,36.305-30.954,60.078-30.954
                                    c23.775,0,46.233,11.571,60.077,30.953c5.919,8.286,17.437,10.209,25.726,4.288c8.288-5.92,10.208-17.438,4.288-25.726
                                    C252.285,193.373,218.606,176.029,182.946,176.029z"/>
                              <path d="M182.946,106.873c-50.938,0-99.694,21.749-133.77,59.67c-6.807,7.576-6.185,19.236,1.392,26.044
                                    c3.523,3.166,7.929,4.725,12.32,4.725c5.051-0.001,10.082-2.063,13.723-6.116c27.091-30.148,65.849-47.439,106.336-47.439
                                    s79.246,17.291,106.338,47.438c6.808,7.576,18.468,8.198,26.043,1.391c7.576-6.808,8.198-18.468,1.391-26.043
                                    C282.641,128.621,233.883,106.873,182.946,106.873z"/>
                              <path d="M360.611,112.293c-47.209-48.092-110.305-74.577-177.665-74.577c-67.357,0-130.453,26.485-177.664,74.579
                                    c-7.135,7.269-7.027,18.944,0.241,26.079c3.59,3.524,8.255,5.282,12.918,5.281c4.776,0,9.551-1.845,13.161-5.522
                                    c40.22-40.971,93.968-63.534,151.344-63.534c57.379,0,111.127,22.563,151.343,63.532c7.136,7.269,18.812,7.376,26.08,0.242
                                    C367.637,131.238,367.745,119.562,360.611,112.293z"/>
                            </g>
                        </svg>
            <svg v-else fill="currentColor" width="26px" height="26px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="m1.293 8.395 1.414 1.414c.504-.504 1.052-.95 1.622-1.359L2.9 7.021c-.56.422-1.104.87-1.607 1.374zM6.474 5.06 3.707 2.293 2.293 3.707l18 18 1.414-1.414-5.012-5.012.976-.975a7.86 7.86 0 0 0-4.099-2.148L11.294 9.88c2.789-.191 5.649.748 7.729 2.827l1.414-1.414c-2.898-2.899-7.061-3.936-10.888-3.158L8.024 6.61A13.366 13.366 0 0 1 12 6c3.537 0 6.837 1.353 9.293 3.809l1.414-1.414C19.874 5.561 16.071 4 12 4a15.198 15.198 0 0 0-5.526 1.06zm-2.911 6.233 1.414 1.414a9.563 9.563 0 0 1 2.058-1.551L5.576 9.697c-.717.451-1.395.979-2.013 1.596zm2.766 3.014 1.414 1.414c.692-.692 1.535-1.151 2.429-1.428l-1.557-1.557a7.76 7.76 0 0 0-2.286 1.571zm7.66 3.803-2.1-2.1a1.996 1.996 0 1 0 2.1 2.1z"></path></g></svg>
            <div id="tooltip-bottom" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
              <span v-if="isConnected">Connected</span>
              <span v-else>Disconnected</span>
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div v-if="btnLogout">
              <a href="/logout" type="button" class="flex text-sm p-2 border-gray-800 rounded-full focus:ring-4 ring-gray-300 dark:focus:ring-gray-600">
                Logout
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
        <li>
          <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
            </svg>

            <span class="ms-3">Home</span>
          </a>
        </li>
        <li>
          <a href="#/sentry" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 44" width="300" height="264">
              <path d="M29,2.26a4.67,4.67,0,0,0-8,0L14.42,13.53A32.21,32.21,0,0,1,32.17,40.19H27.55A27.68,27.68,0,0,0,12.09,17.47L6,28a15.92,15.92,0,0,1,9.23,12.17H4.62A.76.76,0,0,1,4,39.06l2.94-5a10.74,10.74,0,0,0-3.36-1.9l-2.91,5a4.54,4.54,0,0,0,1.69,6.24A4.66,4.66,0,0,0,4.62,44H19.15a19.4,19.4,0,0,0-8-17.31l2.31-4A23.87,23.87,0,0,1,23.76,44H36.07a35.88,35.88,0,0,0-16.41-31.8l4.67-8a.77.77,0,0,1,1.05-.27c.53.29,20.29,34.77,20.66,35.17a.76.76,0,0,1-.68,1.13H40.6q.09,1.91,0,3.81h4.78A4.59,4.59,0,0,0,50,39.43a4.49,4.49,0,0,0-.62-2.28Z" fill="currentColor"></path>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Sentry</span>
            <span v-if="countSentry > 0" class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{countSentry}}</span>
          </a>
        </li>
        <li>
          <a href="#/smtp" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M2.038 5.61A2.01 2.01 0 0 0 2 6v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6c0-.12-.01-.238-.03-.352l-.866.65-7.89 6.032a2 2 0 0 1-2.429 0L2.884 6.288l-.846-.677Z"/>
              <path d="M20.677 4.117A1.996 1.996 0 0 0 20 4H4c-.225 0-.44.037-.642.105l.758.607L12 10.742 19.9 4.7l.777-.583Z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
            <span v-if="countSmtp > 0" class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{countSmtp}}</span>
          </a>
        </li>
        <li>
          <a href="#/log" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Logs</span>
            <span v-if="countLog > 0" class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{countLog}}</span>
          </a>
        </li>
        <li>
          <a href="#/dump" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M18 17h-.09c.058-.33.088-.665.09-1v-1h1a1 1 0 0 0 0-2h-1.09a5.97 5.97 0 0 0-.26-1H17a2 2 0 0 0 2-2V8a1 1 0 1 0-2 0v2h-.54a6.239 6.239 0 0 0-.46-.46V8a3.963 3.963 0 0 0-.986-2.6l.693-.693A1 1 0 0 0 16 4V3a1 1 0 1 0-2 0v.586l-.661.661a3.753 3.753 0 0 0-2.678 0L10 3.586V3a1 1 0 1 0-2 0v1a1 1 0 0 0 .293.707l.693.693A3.963 3.963 0 0 0 8 8v1.54a6.239 6.239 0 0 0-.46.46H7V8a1 1 0 0 0-2 0v2a2 2 0 0 0 2 2h-.65a5.97 5.97 0 0 0-.26 1H5a1 1 0 0 0 0 2h1v1a6 6 0 0 0 .09 1H6a2 2 0 0 0-2 2v2a1 1 0 1 0 2 0v-2h.812A6.012 6.012 0 0 0 11 21.907V12a1 1 0 0 1 2 0v9.907A6.011 6.011 0 0 0 17.188 19H18v2a1 1 0 0 0 2 0v-2a2 2 0 0 0-2-2Zm-4-8.65a5.922 5.922 0 0 0-.941-.251l-.111-.017a5.52 5.52 0 0 0-1.9 0l-.111.017A5.925 5.925 0 0 0 10 8.35V8a2 2 0 1 1 4 0v.35Z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Dump</span>
            <span v-if="countDump > 0" class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{countDump}}</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20 border-r border-gray-200 dark:border-gray-700">
      <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
      </button>
    </div>
  </aside>

  <div class="p-4 sm:ml-64">
    <div class="p-4 dark:border-gray-700 mt-14 relative">
      <RouterView />
    </div>
  </div>
</template>

<style scoped>
  .pre-formatted {
    white-space: pre;
  }
  pre.sf-dump {
    z-index: 0!important;
  }
</style>
