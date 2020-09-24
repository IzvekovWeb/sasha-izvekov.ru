<template>
  <modal 
    :title="title"
    @close="closeModal()"> 
     
      <div slot="body" class="modal-body">
        
        <form id="addForm" ref="addForm" action="#" @submit.prevent="onSubmit()" enctype="multipart/form-data">
          <!-- title -->
          <div class="form-item" :class="{errorInput: $v.title_input.$error}">
            <p class="errorText" v-if="!$v.title_input.required">Поле не может быть пустым!</p>
            <p class="errorText" v-if="!$v.title_input.minLength">Поле не может быть короче {{ $v.title_input.$params.minLength.min }} !</p>
            <label>Название:</label> 
            <input 
              v-model="title_input"
              :class="{error: $v.title_input.$error}"
              @change="$v.title_input.$touch()"
              placeholder="Название проекта/сайта">
          </div> 

          <!-- subtitle -->
          <div class="form-item" :class="{errorInput: $v.subtitle.$error}">
            <p class="errorText" v-if="!$v.subtitle.required">Поле не может быть пустым!</p>
            <p class="errorText" v-if="!$v.subtitle.minLength">Поле не может быть короче {{ $v.subtitle.$params.minLength.min }} !</p>
            <label>Описание:</label> 
            <input 
              v-model="subtitle"
              :class="{error: $v.subtitle.$error}"
              @change="$v.subtitle.$touch()"
              placeholder="Описание проекта/сайта">
          </div> 

          <!-- url -->
          <div class="form-item" :class="{errorInput: $v.url.$error}">
            <p class="errorText" v-if="!$v.url.required">Поле не может быть пустым!</p>
            <p class="errorText" v-if="!$v.url.minLength">Поле не может быть короче {{ $v.url.$params.minLength.min }} !</p>
            <label>Ссылка на страницу:</label> 
            <input 
              v-model="url"
              :class="{error: $v.url.$error}"
              @change="$v.url.$touch()"
              placeholder="https://sasha-izvekov.ru/">
          </div> 

          <!-- img -->
          <div class="form-item" :class="{errorInput: $v.img.$error}">
            <p class="errorText" v-if="!$v.img.required">Поле не может быть пустым!</p>
            <label>Названи картинки ('img.jpg'):</label> 
            <input 
              type="file" 
              id="file" 
              ref="file" 
              :class="{error: $v.img.$error}"
              @change="$v.img.$touch(), handleFileUpload()">
          </div> 
          <!-- date -->
          <div class="form-item" :class="{errorInput: $v.date.$error}">
            <p class="errorText" v-if="!$v.date.required">Поле не может быть пустым!</p>
            <label>Дата создания:</label> 
            <input
              v-model="date"
              type="datetime-local"
              :class="{error: $v.date.$error}"
              @change="$v.date.$touch()">
          </div> 
          <button class="btn btnSuccess" >Добавить!</button>
        </form>  
      </div>
      
  </modal>
  
</template>


<script>
import axios from 'axios'

import modal from '@/components/UI/Modal.vue'
import { required, minLength, maxLength} from 'vuelidate/lib/validators'


export default {
  components: {modal},
  props: {
    title: {
      type: String,
      required: true
    }
  },
  data() {
    return { 
      title_input: "",
      subtitle: "",
      url: "",
      img: "",
      date: "",
      works_arr: null,
      error: null
    }
  },
  validations: {
    title_input: {
      required,
      minLength: minLength(3),
      maxLength: maxLength(20)
    },
    subtitle: {
      minLength: minLength(3),
      maxLength: maxLength(60)
    },
    url: {
      required,
      minLength: minLength(3),
    },
    img: {
      required
    },
    date: {
    }
  },
  mounted: function () {
  },
  methods: { 
    closeModal() { 
      this.title_input = '', 
      this.subtitle = '', 
      this.url = '', 
      this.img = '', 
      this.date = '',

      this.$v.$reset(),
      this.$emit('close')
    },
    handleFileUpload(){
      this.img = this.$refs.file.files[0];
    },
    onSubmit(form){
      this.$v.$touch()
      if(!this.$v.$invalid){
        var formData = new FormData();

        formData.append('title', this.title_input);
        formData.append('description', this.subtitle);
        formData.append('link', this.url);
        formData.append('img_link', this.img);
        formData.append('create', this.date);
  

        axios.post('https://sasha-izvekov.ru/root/api_site/work/create.php', 
          formData, 
          {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
          }
        ).then(function (response) {
          console.log("response: ");
          console.log(response);
        })
        .catch(function (error) {
          console.log("error: " + error);
        });
        

        this.closeModal()
      } 
    } 
  },
}
</script>

<style lang="scss">
.form-item .errorText {
    display: none;
    margin-bottom: 8px;
    font-size: 12.4px;
    color: #de4040;
}
.form-item{
    &.errorInput .errorText {
        display: block;
    }
}
input.error {
    border-color: #de4040;
}
</style>