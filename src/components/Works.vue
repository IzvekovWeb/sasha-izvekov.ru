<template>
  <div class="works">
    <div class="work" v-for="(work, id) in works" :key="id">
      <div class="work__title">
        {{ work.title }}
      </div> 
      <div class="work__subtitle">
        {{ work.subtitle }}
      </div>
      <a class="btn btn-primary work__button" :href="work.url" target="_blank">Посмотреть</a>
      <img class="work__img" :src='work.img' :alt="work.title">
    </div>
  </div>
</template>

<script>
export default {
  props: {
    works: {
      type: Array,
      required: true
    }
  }
}
</script>

<style lang="scss">
  .works {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    flex-basis: 33%;
    width: 100%;
    margin-top: 40px;
    padding: 20px;

    box-shadow: 0 4px 8px -5px rgba(0, 0, 0, 0.5)
  }
  .work {
    position: relative;

    display: flex;
    flex-direction: column;
    justify-content: space-around;

    max-width: 350px;
    width: 100%;
    height: 280px;
    margin:30px 0;

    padding: 5px 10px;
    
    box-shadow: 0 0 10px -5px rgba(0,0,0,0.5);
    overflow: hidden;
    transition: all 0.2s;

    color: #565656;
    &:hover {
      .work__title, .work__subtitle, .work__button, &:after {
        transform: translateX(0);
      }
    }

    &__img {
      position: absolute;
      z-index: 0;
      top: 0;
      left: 0;
      width: 100%;
      
    }
    &:after {
      content: '';
      position: absolute;
      z-index: 1;
      top: 0;
      left: 0;
      bottom: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.9);
      transition: all 0.1s;
      transform: translateY(120%);

    }
    &__title {
      z-index: 2;
      font-family: Helvetica, Arial, sans-serif;
      font-size: 20px;
      font-weight: 600;
      transition: all 0.2s;
      transform: translateX(-120%);
    }
    &__subtitle {
      z-index: 2;
      font-size: 16px;
      transition: all 0.2s;
      transform: translateX(120%);

    }
    &__button {
      z-index: 2;
      max-width: 150px;
      text-align: center;
      font-size: 16px;
      transition: all 0.2s;
      
      transform: translateX(-120%);
      
      &:hover {
        box-shadow: 0 0 10px -5px #000;
      }
    }
    .btn {
      padding: 10px 5px;
    }
  }
</style>