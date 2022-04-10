<template>
    <div>
        <div class="rounded-lg border border-gray-200">
            <table class="table-auto w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-2.5">Choice</th>
                        <th class="p-2.5">Votes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="(option, index) in pollOptions" :key="'option_' + index">
                        <td class="p-2.5">{{ option.value }}</td>
                        <td class="p-2.5">{{ option.voteCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-8 h-[400px]">
            <MglMap :accessToken="accessToken" :mapStyle="mapStyle" @load="onMapLoaded">
                <MglMarker v-for="(loc, index) in voteLocations" :coordinates="loc.coords" :key="'marker_' + index"/>
            </MglMap>
        </div>
    </div>
</template>
<script>
    import Mapbox from "mapbox-gl";
    import promisify from 'map-promisified';
    import { MglMap, MglMarker } from "vue-mapbox";
    import * as turf from '@turf/turf';

    export default {
        components: {
            MglMap,
            MglMarker
        },
        props: [
            'props'
        ],
        data() {
            return {
                accessToken: 'pk.eyJ1IjoiamFtZXNtcGlnb3R0IiwiYSI6ImNsMXNmODdlajI2amEzbG1teHg0ZHF2b3UifQ.MfWfkwkTL7f666AfI4WqIg', // your access token. Needed if you using Mapbox maps
                mapStyle: 'mapbox://styles/mapbox/streets-v11', // your map style
                pollSlug: null,
                pollOptions: null,
                voteLocations: null
            }
        }, 
        mounted() {
            this.pollSlug = this.$props.props.pollSlug;
            this.addMapboxAssets();
            this.loadPoll();
        },
        methods: {
            loadPoll: function() {
                axios.get('/api/poll-results/' + this.pollSlug )
                    .then((response) => {
                        this.pollOptions = response.data.options;
                        this.voteLocations = response.data.locs;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            },
            addMapboxAssets() {
                let linkEl = document.querySelector('head link[href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css"');

                if(!linkEl) {
                    let file = document.createElement('link');
                    file.rel = 'stylesheet';
                    file.href = 'https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css';
                    document.head.appendChild(file)
                }
            },
            async onMapLoaded(event) {
                const asyncActions = event.component.actions;
                
                await asyncActions.fitBounds(
                    this.setBounds(),
                    {
                        padding: { top:20, right:20, bottom:20, left:20 }
                    }
                );

            },
            setBounds() {
                let coordsArray = [];
                if(this.voteLocations) {
                    this.voteLocations.forEach((loc) => {
                        coordsArray.push(loc.coords);
                    });
                    return turf.bbox(turf.lineString(coordsArray));
                }

            }
        },
    }
</script>