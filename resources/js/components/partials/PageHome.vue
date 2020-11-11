<template>
  <div class="container page-home">
    <div class="home">
    </div>
    <div class="card-custom">
      <b-row>
        <b-col md="6" class="box-image">
          <!-- <img src="'/assets/img/gym/nutri.jpg'" > -->
          <img :src="'/assets/img/gym/nutri.jpg'" alt="">
          <h3>ASESOSRIA NUTRICIONAL PROFESIONAL</h3>
          <h2>NUTRICIÓN VIRTUAL</h2>
        </b-col>
        <b-col md="6" class="box-image">
          <img :src="'/assets/img/gym/encasa.jpg'" alt="">
        </b-col>
        <b-col md="6" class="box-image">
          <img :src="'/assets/img/gym/coahs.jpg'" alt="">
        </b-col>
        <b-col md="6" class="box-image">
          <img :src="'/assets/img/gym/personal.jpg'" alt="">
        </b-col>
      </b-row>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    path: String
  }
}
</script>
<style lang="scss">
  .page-home {
    .home {
      width: auto;
      height: 500px;
      margin: auto;
      background-size: 100% 100%;
      animation: banner 10s infinite;
      animation-direction: alternate;
      border-radius: 3px;
      @keyframes banner {
        0%, 30%{
          opacity: 1;
          background-image: url('/assets/img/gym/gym3.jpg');
        }
        31%, 34%{
          opacity: 0.1;
        }
        35%, 65%{
          opacity: 1;
          background-image: url('/assets/img/gym/gym2.jpg');
        }
        66%, 69%{
          opacity: 0.1;
        }
        70%, 100%{
          opacity: 1;
          background-image: url('/assets/img/gym/gym1.jpg');
        }
      }
    }
    .card-custom{
      position: relative;
      border-radius: 3px;
      margin-top: 10px;
      // background: white;
      /* .box-image{
        padding: 15px;
        img {
          width: 100%;
          height: 100%;
          background-size: 100% 100%;
          opacity: 0.5;
        }
      } */
      .box-image {
        position: relative;
        overflow: hidden;
        padding: 15px;

        h3 {
          //padding: 100px;
          position: relative;
          z-index: 100;
          color: white;
        }
        h2 {
          //padding: 100px;
          position: relative;
          z-index: 100;
          color: white;
        }
        img {
          position: absolute;
          left: 0;
          top: 0;
          width: 100%;
          height: auto;
          opacity: 0.6;
          border-radius: 3px;
          padding: 15px;
        }
      }
    }
  }

</style>
