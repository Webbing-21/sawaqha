@extends('Admin.layouts.main')

@section("title", "Products - Create")
@section("loading_txt", "Create")

@section("content")
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">إضافة منتج</h1>
    <a href="{{ route("admin.products.show") }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-arrow-left fa-sm text-white-50"></i> العودة إلى الخلف</a>
</div>
@php
    $categories = App\Models\Category::where('isMainCat', 0)->latest()->get();
@endphp
<div class="card p-3 mb-3" id="products_wrapper">
    <div class="d-flex justify-content-between" style="gap: 16px">
        <div class="w-50">
            <div class="form-group w-100">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" class="form-control" id="name"  placeholder="اسم المنتج" v-model="name">
            </div>
            <div class="form-group w-100">
                <label for="price" class="form-label">سعر البيع</label>
                <input type="number" class="form-control" id="price"  placeholder="سعر البيع" v-model="price">
            </div>
            <div class="form-group w-100">
                <label for="quantity" class="form-label">الكمية</label>
                <input type="number" class="form-control" id="quantity"  placeholder="الكمية" v-model="quantity">
            </div>
            <div class="form-group w-100">
                <label for="wholesale_price" class="form-label">سعر الجملة</label>
                <input type="number" class="form-control" id="wholesale_price"  placeholder="سعر الجملة" v-model="wholesale_price">
            </div>
            <div class="form-group w-100">
                <label for="least_quantity_wholesale" class="form-label">أقل كمية جملة</label>
                <input type="number" class="form-control" id="least_quantity_wholesale"  placeholder="أقل كمية جملة" v-model="least_quantity_wholesale">
            </div>
            <div class="form-group w-100">
                <label for="categories" class="form-label">الفئة</label>
                <select name="categories" id="categories" class="form-control" v-model="category_id">
                    <option value="" disabled>--- اختر</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">@{{ cat.name }}</option>
                </select>
            </div>
        </div>
        <div class="form-group w-50">
            <label for="Description" class="form-label">الوصف</label>
            <textarea rows="7" class="form-control" id="Description"  placeholder="الوصف" style="resize: none" v-model="description">
            </textarea>
            <label for="Description-sec" class="form-label">الوصف الثان</label>
            <textarea rows="7" class="form-control" id="Description-sec"  placeholder="الوصف الثان" style="resize: none" v-model="sec_description">
            </textarea>
            <div class="form-group pt-4 pb-4" style="width: max-content; height: 300px;min-width: 100%">
                <label for="thumbnail" class="w-100 h-100">
                    <svg v-if="!thumbnail && !thumbnail_path" xmlns="http://www.w3.org/2000/svg" className="icon icon-tabler icon-tabler-photo-up" width="24" height="24" viewBox="0 0 24 24" strokeWidth="1.5" style="width: 100%; height: 100%; object-fit: cover; padding: 10px; border: 1px solid; border-radius: 1rem" stroke="#043343" fill="none" strokeLinecap="round" strokeLinejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 8h.01" />
                        <path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5" />
                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3.5 3.5" />
                        <path d="M14 14l1 -1c.679 -.653 1.473 -.829 2.214 -.526" />
                        <path d="M19 22v-6" />
                        <path d="M22 19l-3 -3l-3 3" />
                    </svg>
                    <img v-if="thumbnail_path" :src="thumbnail_path" style="width: 100%; height: 100%; object-fit: contain; padding: 10px; border: 1px solid; border-radius: 1rem" />
                </label>
            <input type="file" class="form-control d-none" id="thumbnail"  placeholder="صورة الفئة" @change="handleChangeThumbnail">
            </div>
        </div>
    </div>
    <div class="w-100 form-group">
        <label for="gallary" class="form-control"
        style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 140px; font-size: 22px;">رفع صور المنتج*
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-plus" width="55"
            height="55" viewBox="0 0 24 24" stroke-width="2" stroke="#2c3e50" fill="none" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M15 8h.01"></path>
            <path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5"></path>
            <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4"></path>
            <path d="M14 14l1 -1c.67 -.644 1.45 -.824 2.182 -.54"></path>
            <path d="M16 19h6"></path>
            <path d="M19 16v6"></path>
        </svg>
    </label>
        <input type="file" id="gallary" multiple="" class="form-control" @change="handleChangeImages" style="display: none;">
    </div>
    <div id="preview-gallery" class="mt-3">
        <div class="row" v-if="images && images.length > 0">
           <div v-for="(img, index) in images_path" :key="index"
              class="col-lg-3 col-md-6 mb-4">
              <button
                 style="background: transparent; border: medium; border-radius: 50%; float: right;" @click="handleDeleteImage(index)">
                 <svg
                    xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#043343" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M18 6l-12 12"></path>
                    <path d="M6 6l12 12"></path>
                 </svg>
              </button>
              <img :src="img"
                 style="width: 100%; height: 250px; object-fit: cover;" alt="gallery">
           </div>
        </div>
     </div>
     <div class="d-flex justify-content-between mb-4">
        <h2>هل للمنتج احجام؟</h2>
        <button class="btn btn-primary" @click="handleAddSize">اضف احجام</button>
     </div>
    <table class="table" v-if="sizes && sizes.length > 0">
        <thead>
          <tr>
            <th scope="col">الحجم</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="option, index in sizes" :key="index">
            <td>
                <input type="text" name="size" id="size" class="form-control" placeholder="Size" v-model="sizes[index]['size']">
            </td>
            <td>
                <button class="btn btn-danger" @click="handleRemoveSize(index)">إزالة</button>
            </td>
          </tr>
        </tbody>
    </table>
     <div class="d-flex justify-content-between mb-4">
        <h2>هل للمنتج ألوان؟</h2>
        <button class="btn btn-primary" @click="handleAddColor">اضف ألوان</button>
     </div>
     <table class="table" v-if="colors && colors.length > 0">
        <thead>
          <tr>
            <th scope="col">اسم اللون</th>
            <th scope="col">رمز اللون</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="option, index in colors" :key="index">
            <td>
                <input type="text" name="size" id="size" class="form-control" placeholder="اسم اللون" v-model="colors[index]['color']">
            </td>
            <td>
                <input type="color" name="color" id="color" class="form-control" placeholder="اللون" v-model="colors[index]['code']">
            </td>
            <td>
                <button class="btn btn-danger" @click="handleRemoveColor(index)">ازالة</button>
            </td>
          </tr>
        </tbody>
    </table>

    <div class="form-group">
        <button class="btn btn-success w-25" @click="create" style="display: block;margin: auto">إضافة</button>
    </div>
</div>

@endSection

@section("scripts")
<script>
const { createApp, ref } = Vue

createApp({
    data() {
        return {
            name: null,
            description: null,
            sec_description: null,
            category_id: '',
            price: 0,
            quantity: 0,
            thumbnail_path: null,
            thumbnail: null,
            wholesale_price: 0,
            least_quantity_wholesale: 0,
            categories: @json($categories),
            images_path: [],
            sizes: [],
            colors: [],
            images: []
        }
    },
    methods: {
        handleAddSize() {
            this.sizes.push({
                size: "",
            })
        },
        handleRemoveSize(index) {
            this.sizes.splice(index, 1)
        },
        handleAddColor() {
            this.colors.push({
                color: "",
                code: "",
            })
        },
        handleRemoveColor(index) {
            this.colors.splice(index, 1)
        },
        handleChangeThumbnail(event) {
            this.thumbnail = event.target.files[0]
            this.thumbnail_path = URL.createObjectURL(event.target.files[0])
        },
        handleChangeImages(event) {
            let files = Array.from(event.target.files)
            files.map(file => {
                this.images.push(file)
                this.images_path.push(URL.createObjectURL(file))
            })
        },
        handleDeleteImage(index) {
            let arr = this.images
            arr.splice(index, 1)
            this.images = arr
            let arr_paths  = this.images_path
            arr_paths.splice(index, 1)
            this.images_path = arr_paths
        },
        async create() {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`{{ route("admin.products.create") }}`, {
                    name: this.name,
                    description: this.description,
                    sec_description: this.sec_description,
                    price: this.price,
                    quantity: this.quantity,
                    wholesale_price: this.wholesale_price,
                    least_quantity_wholesale: this.least_quantity_wholesale,
                    images: this.images,
                    category_id: this.category_id,
                    main_image: this.thumbnail,
                    sizes: this.sizes,
                    colors: this.colors,
                },
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                },
                );
                if (response.data.status === true) {
                    document.getElementById('errors').innerHTML = ''
                    let error = document.createElement('div')
                    error.classList = 'success'
                    error.innerHTML = response.data.message
                    document.getElementById('errors').append(error)
                    $('#errors').fadeIn('slow')
                    setTimeout(() => {
                        $('.loader').fadeOut()
                        $('#errors').fadeOut('slow')
                        window.location.href = '{{ route("admin.products.show") }}'
                    }, 1300);
                } else {
                    $('.loader').fadeOut()
                    document.getElementById('errors').innerHTML = ''
                    $.each(response.data.errors, function (key, value) {
                        let error = document.createElement('div')
                        error.classList = 'error'
                        error.innerHTML = value
                        document.getElementById('errors').append(error)
                    });
                    $('#errors').fadeIn('slow')
                    setTimeout(() => {
                        $('#errors').fadeOut('slow')
                    }, 5000);
                }

            } catch (error) {
                document.getElementById('errors').innerHTML = ''
                let err = document.createElement('div')
                err.classList = 'error'
                err.innerHTML = 'server error try again later'
                document.getElementById('errors').append(err)
                $('#errors').fadeIn('slow')
                $('.loader').fadeOut()

                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        }
    },
}).mount('#products_wrapper')
</script>
@endSection
