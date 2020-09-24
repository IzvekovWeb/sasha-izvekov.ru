<template>
  <div class="wrapper">

    <!-- header -->

    <div class="wrapper-content">
      <section>
        <div class="container"> 
          <h1>Мои работы</h1>

          <works :works="works"/>
          <button class="add-work btn btn-primary" @click="addWorkModal = !addWorkModal">Добавить</button>

          <addWorkModal v-show="addWorkModal" title="Добавить работу" @close="addWorkModal = false"/>
        </div>
      </section>
    </div>

     <!-- footer -->
    
  </div>
</template>

<script> 
import works from "@/components/Works"
import addWorkModal from "@/components/elements/AddWorkModal"

export default {
  components: {works,addWorkModal},
  data () {
    return {
      addWorkModal: false,
      works: [
        {
          title: 'Добрый картон',
          subtitle: 'Интернет-магазин картона',
          url: 'http://sasha-izvekov.ru/cardboard/',
          img: './img/ca.jpg'
        },
        {
          title: 'Advice Finance',
          subtitle: 'Лендинг компании по обучению финансированию',
          url: 'https://sasha-izvekov.ru/advice-finance/index.php',
          img: './img/finance.jpg'
        },
        {
          title: 'Интерактивное ТВ',
          subtitle: 'Лендинг интерактивного ТВ, интернет-провайдера Данцер',
          url: 'https://sasha-izvekov.ru/tv_landing/',
          img: './img/tv.jpg'
        },
        {
          title: 'Автоэлектрика',
          subtitle: 'Сайт автоэлектрики и электроники',
          url: 'https://sasha-izvekov.ru/autoelectric/',
          img: './img/autoelectric.jpg'
        },
        {
          title: 'Телепрограмма Данцер ТВ',
          subtitle: 'Список каналов и передак компании ДАНЦЕР',
          url: 'https://sasha-izvekov.ru/tv_program/',
          img: './img/tv_program.jpg'
        },
        {
          title: 'Ремонт окон',
          subtitle: 'Сайт компаниии по ремонту окон в Москве',
          url: 'https://sasha-izvekov.ru/new_ro99/',
          img: './img/new_ro99.jpg'
        },
        {
          title: 'Касса билетов в кино',
          subtitle: 'Курсовая работа. Выполнена с импользование PHP и MySQL',
          url: 'https://sasha-izvekov.ru/kassa',
          img: './img/kassa.jpg'
        },
        {
          title: 'Битрикс',
          subtitle: 'Лендинг битрикс партнёров. Без дизайна.',
          url: 'https://sasha-izvekov.ru/bitrix',
          img: './img/bitrix.jpg'
        },
        {
          title: 'Модальные окна на VUE',
          subtitle: 'Примеры модальных окон, сделанных на vue.js',
          url: 'https://sasha-izvekov.ru/vue/modals',
          img: './img/vue_modals.jpg'
        },
        {
          title: 'Заметки на VUE',
          subtitle: 'Страница с заметками, выполнена на vue.js',
          url: 'https://sasha-izvekov.ru/vue/notes',
          img: './img/vue_notes.jpg'
        },
      ]
    }
  }

} 
</script> 
<style lang="scss">
  .add-work {
    float: right;
    margin: 40px 40px 0 0;
  }
</style>