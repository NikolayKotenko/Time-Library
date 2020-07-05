<template>
    <div id="DynamicBlockCalcTime">
        <div v-if="this.selected_tag === 'films' || this.selected_tag === 'podcasts'" :class="'BlockTime '+this.selected_tag"  >
            <div class="BlockInputs">
                <header>Hours</header>
                <input class="form-control" type="number">
            </div>
            <div class="BlockInputs">
                <header>Minutes</header>
                <input class="form-control" type="number">
            </div>
        </div>
        <div v-if="this.selected_tag === 'books' || this.selected_tag === 'audio-books'" :class="'BlockTime '+this.selected_tag">
            <div class="BlockInputs">
                <header>Number of pages</header>
                <input class="form-control" type="number">
            </div>
            <div class="BlockInputs">
                <header>Percent</header>
                <input class="form-control" type="number">
            </div>
        </div>
        <div v-if="this.selected_tag === 'serials' || this.selected_tag === 'anime'" :class="'BlockTime '+this.selected_tag">
            <div class="BlockInputs">
                <header>Number of Seasons</header>
                <input class="form-control" type="number">
            </div>
            <div class="BlockInputs">
                <header>Hours</header>
                <input class="form-control" type="number">
            </div>
            <div class="BlockInputs">
                <header>Minutes</header>
                <input class="form-control" type="number">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // props: ["note", "tag"],
        data() {
            return {
                selected_tag: [],
            }
        },
        mounted() {
            console.log('Component TagsDynamic mounted.');
        },
        created() {
            /* Повесить обработчик на глобальную шину, слушаем выбор тега, вызываем функцию записывающую в локальную дейта */
            this.$bus.$on('SelectedTagOnGlobalBus', this.writeTagLocalData)
        },
        methods: {
            writeTagLocalData(tag){
                this.selected_tag = tag;
            }
        },

    }
</script>
