<template>
    <div v-if="active" class="z-100 fixed w-full h-full top-0 left-0 flex items-center justify-center transition-all duration-75 ease-in">
        <transition
            enter-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0">

            <div class="absolute w-full h-full transition-opacity">
                <div class="absolute inset-0 bg-gray-900 opacity-75" :click="close"></div>
            </div>

        </transition>

        <transition 
            enter-class="ease-out duration-300"
            enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
            leave-class="ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

            <div class="bg-white w-2/3 lg:w-1/2 mx-auto rounded shadow-lg z-50 overflow-hidden transform transition-all overflow-y-scroll max-h-[90%]"
                role="dialog"
                aria-modal="true">

                <div class="modal-content p-6 text-left">
                    <div class="flex justify-between items-center pb-3">
                        <p class="text-2xl font-bold">
                            <slot name="title">
                                {{ title }}
                            </slot>
                        </p>
                        <div 
                            class="modal-close hover:cursor-pointer z-50"
                            @click="close"
                        >
                            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>
        
                    <!--Body-->
                    <slot name="body">
                        
                    </slot>
                </div>
            </div>

        </transition>
        
    </div>
</template>

<script>
  export default {
    data: function() {
        return {
            active: false,
            data: {},
            title: null
        }
    },
    methods: {
        close() {
            this.active = false;
            this.$emit('close');
        },
        open() {
          this.active = true;
        },
        set(data, title) {
            this.data = data;
            this.title = title;
        }
    },
    mounted () {
        this.$nextTick(function () {
            this.$root.$on('set-modal-data', this.set);
            this.$root.$on('open-modal', this.open);
        }.bind(this));
    }
  };
</script>