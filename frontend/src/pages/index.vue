<template>
  <BaseLayout>
    <div class="my-10 mx-auto" id="map" style="height: 700px; width: 80%;"></div>
  </BaseLayout>
</template>

<script>
import { Loader } from "@googlemaps/js-api-loader";
import { http } from "@utils/http.mjs";
import BaseLayout from "@layouts/BaseLayout.vue";

export default {
  components: {
    BaseLayout,
  },
  mounted() {
    this.initMap();
  },
  methods: {
    async fetchCarData() {
      try {
        const response = await http.get("/routes");

        if (
          response.data &&
          response.data.routes &&
          Array.isArray(response.data.routes) &&
          response.data.routes.length > 0
        ) {
          const legs = response.data.routes[0].legs || [];
          return legs.map((leg) => ({
            start_location: {
              lat: leg.start_location.lat,
              lng: leg.start_location.lng,
            },
            end_location: {
              lat: leg.end_location.lat,
              lng: leg.end_location.lng,
            },
            distance: leg.distance.text,
            duration: leg.duration.text,
          }));
        }
        return [];
      } catch (error) {
        return [];
      }
    },
    getRandomColor() {
      const letters = "0123456789ABCDEF";
      let color = "#";
      for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    },
    async initMap() {
      const loader = new Loader({
        apiKey: "AIzaSyBt2dTfggXDgUgNR9jdKL7xysDeKcy28Og",
        version: "weekly",
        libraries: ["marker"],
      });

      try {
        const google = await loader.load();
        const map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: 47.497913, lng: 19.040236 }, 
          zoom: 12,
          mapId: "8a05f078f0e5cfc8",
        });

        const cars = await this.fetchCarData();
        const nyugatiTer = { lat: 47.511599, lng: 19.056994 }; 

        cars.forEach((car) => {
          const { start_location, end_location } = car;

          if (
            !start_location ||
            !end_location ||
            isNaN(start_location.lat) ||
            isNaN(start_location.lng)
          ) {
            console.error("Invalid coordinates for car:", car);
            return;
          }

          const carPosition = start_location;

          const markerElement = document.createElement("div");
          markerElement.style.width = "10px";
          markerElement.style.height = "10px";
          markerElement.style.backgroundColor = this.getRandomColor();
          markerElement.style.borderRadius = "50%";
          markerElement.style.border = "2px solid white";
          markerElement.style.boxShadow = "0 0 5px rgba(0,0,0,0.5)";

          new google.maps.marker.AdvancedMarkerElement({
            map,
            position: carPosition,
            content: markerElement,
          });

          const directionsService = new google.maps.DirectionsService();
          const directionsRenderer = new google.maps.DirectionsRenderer({
            map,
            suppressMarkers: true,
            polylineOptions: {
              strokeColor: this.getRandomColor(),
              strokeWeight: 2,
            },
          });

          directionsService.route(
            {
              origin: carPosition,
              destination: nyugatiTer,
              travelMode: google.maps.TravelMode.DRIVING,
            },
            (result, status) => {
              if (status === google.maps.DirectionsStatus.OK) {
                directionsRenderer.setDirections(result);
              } else {
                console.error("Failed to fetch route:", status);
              }
            }
          );
        });
      } catch (error) {
        console.error("Error initializing map:", error);
      }
    }
  }
}

</script>

<style>
#map {
  height: 100%;
}
</style>
