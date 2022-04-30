<template>
    <form v-if="dataFetched" action="" class="">
        <select 
            name="lang"
            @change="submit($event)"
            id="lang-select"
            v-model="selectedLocale"
            class="block w-full mt-0 text-lg pl-2 pr-8 bg-transparent border-0 focus:ring-0 focus:border-black"
        >
            <option 
                v-for="(locale, index) in locales"
                :value="locale.value"
                :aria-label="locale.label"
                :key="'locale_' + index"
            >{{ locale.text }}</option>
        </select>
    </form>
    <div v-else>

    </div>
</template>
<script>
    import NiceSelect from "nice-select2/dist/js/nice-select2";
    
    export default {
        data() {
            return {
                locales: null,
                selectedLocale: null,
                dataFetched: false
            }
        },
        mounted() {
            this.getLocales();
        },
        methods: {
            getLocales() {
                axios.get('/api/get-locales')
                    .then((response) => {
                        this.locales = response.data.locales;
                        
                        this.locales.forEach((locale) => {
                            if(response.data.selectedLocale === locale.value) {
                                this.selectedLocale = locale.value;
                            }
                        });

                        console.log(this.selectedLocale);
                        
                        this.dataFetched = true;

                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            submit(event) {
                axios.post('/api/change-locale', {
                    locale: event.target.value
                })
                .then((response) => {
                    console.log(response.data);
                    window.location.reload();
                })
                .catch((error) => {
                    console.log(error);
                });

            }
        }
    }
</script>