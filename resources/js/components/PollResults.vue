<template>
    <div class="flex flex-col lg:flex-row justify-between lg:gap-x-4 items-start" v-if="dataFetched">
        <div :class="{'lg:w-1/2' : voteLocations}" class="w-full  rounded-lg border border-gray-200">
            <table class="table-auto w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-2.5 text-left">{{ this.$trans.get('generic.choice') }}</th>
                        <th class="p-2.5 text-left">{{ this.$trans.get('generic.votes') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="(option, index) in pollOptions" :key="'option_' + index">
                        <td class="p-2.5 text-left">{{ option.value }}</td>
                        <td class="p-2.5 text-left">{{ option.voteCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="voteLocations" class="w-full lg:w-1/2 overflow-hidden rounded-lg lg:mt-0 mt-8 h-[300px] lg:h-[400px]">
            <MglMap 
                :accessToken="accessToken"
                :mapStyle="mapStyle"
                @load="onMapLoaded">
                <MglMarker 
                    v-for="(loc, index) in voteLocations"
                    :coordinates="loc.coords"
                    :key="'marker_' + index"
                    :color="loc.color">
                        <MglPopup>
                            <div>{{ loc.option }}</div>
                        </MglPopup>
                </MglMarker>

                <MglNavigationControl position="top-right" />
            </MglMap>
        </div>
    </div>
    <div v-else class="w-full flex justify-center py-8">
        <svg role="status" class="w-12 h-12 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"></path>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"></path>
        </svg>
    </div>
</template>
<script>
    import { 
        MglMap,
        MglMarker,
        MglPopup,
        MglAttributionControl,
        MglNavigationControl,
    } from "vue-mapbox";

    import bbox from '@turf/bbox';
    import * as turf from '@turf/helpers';

    export default {
        components: {
            MglMap,
            MglMarker,
            MglPopup,
            MglNavigationControl,
            MglAttributionControl
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
                voteLocations: null,
                dataFetched: false
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
                        this.dataFetched = true;
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
                    file.href = 'https://api.tiles.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css';
                    document.head.appendChild(file)
                }
            },
            async onMapLoaded(event) {
                const asyncActions = event.component.actions;
                
                if(this.voteLocations.length < 2) {
                    await asyncActions.panTo(this.voteLocations[0].coords);
                }
                else { 
                    await asyncActions.fitBounds(
                        this.setBounds(),
                        {
                            padding: { top:30, right:30, bottom:30, left:30 }
                        }
                    );
                }

            },
            setBounds() {
                let coordsArray = [];
                if(this.voteLocations) {
                    this.voteLocations.forEach((loc) => {
                        coordsArray.push(loc.coords);
                    });
                    return bbox(turf.lineString(coordsArray));
                }

            }
        },
    }
</script>