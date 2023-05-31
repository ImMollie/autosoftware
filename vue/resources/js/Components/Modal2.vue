<template>
<button @click="change" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
    Modal
  </button>
  
  <div id="popup-modal" tabindex="-1" :class="[Popup == true ? 'block' : 'hidden']" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center block p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-400 bg-opacity-90 shadow-lg">
      <div class="relative w-full max-w-[1000px] max-h-full">
          <div class="relative bg-gray-300 rounded-lg shadow">
              <button type="button" class="absolute top-3 right-2.5 text-gray-500 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="popup-modal">
                  <svg aria-hidden="true" @click="change" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  <span class="sr-only">Close modal</span>
              </button>
              <div class="p-6 text-center">
                  <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Widok pojedynczego elementu</h3>
              </div>
              <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" @click="sortBy('uuid')" class="px-6 py-3">
                        UUID
                    </th>
                    <th scope="col" @click="sortBy('date')" class="px-6 py-3">
                        Data
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Treść
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                        {{ message.UUID }}
                    </th>
                    <td class="px-6 py-4">
                        {{ message.date.date }}
                    </td>
                    <td class="px-6 py-4">
                        {{ message.content }}
                    </td>
                </tr>
            </tbody>
        </table>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    name: 'Modal', 
    components: {
    },
    props: [
        'message',
    ],
    data() {
        return {
            Popup: false,
        };
    },
    methods:{
        change(){
            this.Popup = !this.Popup;
        }
    }
}
</script>
