<script setup>
import {Head, Link, useForm, usePage, router} from '@inertiajs/vue3';
import MySelect from "@/Components/MySelect.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {reactive, ref} from "vue";


const products = reactive(usePage().props.products)
const categories = usePage().props.categories
const systemSelected =ref(null)
const priceSelected =ref(null)
const formSelected = ref(null)


const title = ref('')
const system = ref({})
const price = ref({})

const form = useForm({
    categories:{},
    title:'',
})

const submit = () =>{
    form.categories = formSelected.value.selectedValue
    form.post('/',{
        onSuccess:(res) =>{
            console.log(res)
            products.value = res.props.products
        }
    })
}

const search = () => {
    system.value = systemSelected.value.selectedValue
    price.value = priceSelected.value.selectedValue
    router.get('/', {title:title.value, price:price.value,system:system.value }, {
        onSuccess:(res) =>{
            products.value = res.props.products
        }
    });
}


</script>

<template>
    <Head title="Epic Partners" />
    <div class="p-5 m-5">
        <h1 class="text-xl text-center">My application</h1>
        <div class="flex w-full justify-between my-10 ">
            <div class="w-1/4 flex flex-col items-center justify-center">
                <p>Название</p>
                <text-input v-model="title" placeholder="title" class="w-2/3"></text-input>
            </div>
            <div class="w-1/4 flex flex-col items-center justify-center">
                <p>Система</p>
                <MySelect ref="systemSelected" :data="['IOS', 'Android']" :mode="'tags'" class="w-2/3"></MySelect>
            </div>
            <div class="w-1/4 flex flex-col items-center justify-center">
                <p>Стоимость</p>
                <MySelect ref="priceSelected" :data="['Платные', 'Бесплатные']" :mode="'tags'" class="w-2/3"></MySelect>
            </div>
            <div class="w-1/4 flex flex-col items-center justify-center">
                <p>Применить</p>
                <primary-button @click.prevent="search">Search</primary-button>
            </div>
        </div>
        <div>
            <table class="table-auto w-full ">
                <thead class="bg-gray-200 ">
                <tr>
                    <th>Product</th>
                    <th>Categories</th>
                </tr>
                </thead>
                <tbody class="bg-gray-100">
                <tr v-for="product in products" class="text-center">
                    <td>{{product.title}}</td>
                    <td class="flex gap-4 justify-center">
                       <Link :href="route('home', {category: category.title})" v-for="category in product.categories" class="text-blue-600"> {{ category.title }} </Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <h1 class="text-center text-3xl my-10 text-gray-700">Форма добавления новых приложения для тестирования</h1>
    </div>
    <div class="flex justify-center">
        <form action="" class="flex flex-col items-center w-3/4  mb-4">
            <div class="w-1/2 mb-4 flex flex-col items-center">
                <p class="mb-2">Название приложения</p>
                <text-input v-model="form.title" placeholder="title" class="w-2/3"></text-input>
            </div>
            <div class="w-1/2 mb-4 flex flex-col items-center">
                <p class="mb-2">Категории</p>
                <MySelect ref="formSelected" :data="categories.map(category=>category.title)" :mode="'tags'" class="w-2/3" ></MySelect>
            </div>
            <div class="w-1/2 mb-8 flex flex-col items-center">
                <primary-button @click.prevent="submit">Создать</primary-button>
            </div>
        </form>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
