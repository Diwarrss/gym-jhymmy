<template>
  <div class="container page-home">
    <div class="contenido-home">
      <b-carousel
        id="carousel-1"
        v-model="slide"
        :interval="4000"
        controls
        indicators
        style="text-shadow: 1px 1px 2px #333;"
        @sliding-start="onSlideStart"
        @sliding-end="onSlideEnd"
      >
        <b-carousel-slide img-src="/assets/img/gym/gym1.jpg"></b-carousel-slide>

        <b-carousel-slide img-src="/assets/img/gym/gym2.jpg"></b-carousel-slide>

        <b-carousel-slide img-src="/assets/img/gym/gym3.jpg"></b-carousel-slide>

        <b-carousel-slide>
          <template #img>
            <img
              class="d-block img-fluid w-100"
              width="1024"
              height="480"
              src="/assets/img/gym/gym4.jpg"
              alt="image slot"
            >
          </template>
        </b-carousel-slide>
      </b-carousel>
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
          <h3>ENTRENATE EN CASA CON ASESORÍA PROFESIONAL</h3>
          <h2>MY COACH</h2>
        </b-col>
        <b-col md="6" class="box-image">
          <img :src="'/assets/img/gym/coach.jpg'" alt="">
          <h3>LOS ENTRENADORES VAN A TU CASA</h3>
          <h2>@ HOME</h2>
        </b-col>
        <b-col md="6" class="box-image">
          <img :src="'/assets/img/gym/personal.jpg'" alt="">
          <h3>TODA LA MOTIVACIÓN DE UN ENTRENADOR PERSONALIZADO EN VIVO</h3>
          <h2>MY COACH</h2>
        </b-col>
      </b-row>
    </div>

  </div>
</template>
<script>
export default {
  props: {
    path: String
  },
  data() {
    return {
      slide: 0,
      sliding: null
    }
  },
  methods: {
    onSlideStart(slide) {
      this.sliding = true
    },
    onSlideEnd(slide) {
      this.sliding = false
    }
  }
}
</script>
<style lang="scss">
  .page-home {
    .contenido-home {
      .carousel-inner{
        width: auto;
        height: 500px;
        margin: auto;
        background-size: 100% 100%;
        border-radius: 5px;
      }
    }
    .card-custom{
      position: relative;
      border-radius: 3px;
      margin-top: 10px;
      .box-image {
        position: relative;
        overflow: hidden;
        padding: 100px;
        text-align: center;
        h3 {
          //padding: 100px;
          position: relative;
          z-index: 100;
          color: white;
          font-size: 20px;
        }
        h2 {
          //padding: 100px;
          position: relative;
          z-index: 100;
          color: white;
          font-size: 40px;
          font-weight: bold;
        }
        img {
          position: absolute;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          opacity: 0.5;
          border-radius: 20px;
          padding: 15px;
          margin: auto;
        }
      }
    }
  }
  /* .navbar{
    z-index: 1000;
    position: fixed;
    width: 100%;
    border: unset;
    background-color: black;

  } */
</style>
