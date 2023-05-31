<template>
    <h3 class="text-center py-5">Dodaj nową</h3>
    <div class="relative overflow-x-auto mb-5 pb-5 rounded-lg m-3">
        <form @submit.prevent class="h-full w-full">
            <div class="flex justify-between">
                <div class="w-1/2 flex justify-center">
                    <input type="text" v-model="form.content" id="dsa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5"
                        placeholder="Wpisz wiadomosc" required>
                </div>
                <div class="w-1/2 flex justify-center">
                    <input type="submit" @click="onSubmit" id="dasda"
                        class="text-white bg-gradient-to-br from-purple-500 to-blue-500 focus:ring-2 focus:outline-none focus:ring-blue-400 font-medium rounded-lg px-5 py-2.5 text-center text-sm"
                        value="Dodaj">
                </div>
            </div>
        </form>
    </div>
    <h3 class="text-center py-5">Lista wiadomości</h3>
    <div class="relative overflow-x-auto mt-4 pt-5 border border-black rounded-lg m-3">
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
                    <th scope="col" class="px-6 py-3">
                        Modal
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="message in sortedMessages" :key="message.id" class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                        {{ message.UUID }}
                    </th>
                    <td class="px-6 py-4">
                        {{ message.date.date }}
                    </td>
                    <td class="px-6 py-4">
                        {{ message.content }}
                    </td>
                    <td class="px-6 py-4">
                        <Modal :message="message" /> 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import Modal from '../Components/Modal2.vue';
export default {
    name: "Message",
    components: {
        Modal,
    },
    props: [
        'messages',
    ],
    mounted()
    {
        this.sortedMessages = this.messages;
    },
    data() {
        return {
            sortedMessages: [],
            sort: 'asc',
        };
    },
    setup() {
        const form = useForm({            
            content: null,            
        })
        return { form }
    },
    methods: {
        onSubmit() {
            console.log('asd');
            this.form.post('/create', {
                onSuccess: () => {
                    this.form.reset();

                }
            })
        },        
        sortBy(column){
            this.sort = this.sort === 'asc' ? 'desc' : 'asc';
            if(column == 'uuid'){

                this.sortedMessages.sort((a,b) => {
                    const wynik = a.UUID.localeCompare(b.UUID);
                    return this.sort === 'asc' ? wynik : -wynik;
                });
            }
            if(column == 'date'){
                this.sortedMessages.sort((a,b) => {
                    const wynik = new Date(b.date.date) - new Date(a.date.date);
                    return this.sort === 'asc' ? wynik : -wynik;
                })
            }
            
        } 
        
    },    
};
</script>