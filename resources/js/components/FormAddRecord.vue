<template>
    <div>
        <navbar></navbar>
        <div id="BlockFormAddNewRecord">
            <header id="header">
                <h1>Add note</h1>
                <input type="text" class="form-control" v-model="note.name" placeholder="name source" >
                <textarea class="form-control" v-model="note.desc" cols="30" rows="3" placeholder="description source"></textarea>
            </header>
            <div id="tags">
                <label :for="tag.id" v-for="tag in  $store.state.tags" v-bind:key="tag.id">
                    <input type="radio" :id="tag.id" :value="tag.id" v-model="note.tag"><span>{{tag.name}}</span>
    <!--                В инпуте событие отправляющее по change в bus
                    @change="sendTag(note.tag)"-->
                </label>
                {{note.tag}}
            </div>

            <div id="DynamicBlockCalcTime">
                <div v-if="note.tag === 'films' || note.tag === 'podcasts' || note.tag === 'video-self-dev'" :class="'BlockTime '+note.tag"  >
                    <div class="BlockInputs">
                        <header>Hours</header>
                        <input class="form-control" type="number" v-model="timetag.hours">
                    </div>
                    <div class="BlockInputs">
                        <header>Minutes</header>
                        <input class="form-control" type="number" v-model="timetag.minutes">
                    </div>
                    <span>{{note.tag}} Time: {{this.filmTime}}</span>
                </div>
                <div v-if="note.tag === 'audio-books'" :class="'BlockTime '+note.tag">
                    <div class="BlockInputs">
                        <header>Percent</header>
                        <input class="form-control" type="number" v-model="timetag.percent">
                    </div>
                    <div class="BlockInputs">
                        <header>Total time audio-books</header>
                        <input class="form-control" type="number" v-model="timetag.total_time_audio_books">
                    </div>
                </div>
                <div v-if="note.tag === 'books'" :class="'BlockTime '+note.tag">
                    <div class="BlockInputs">
                        <header>Number of pages</header>
                        <input class="form-control" type="number" v-model="timetag.number_of_pages">
                    </div>
                    <div class="BlockInputs">
                        <header>Percent</header>
                        <input class="form-control" type="number" v-model="timetag.percent">
                    </div>
                </div>
                <div v-if="note.tag === 'serials' || note.tag === 'anime'" :class="'BlockTime '+note.tag">
                    <div class="BlockInputs">
                        <header>Number of Seasons</header>
                        <input class="form-control" type="number" v-model="timetag.number_of_seasons">
                    </div>
                    <div class="BlockInputs">
                        <header>Series</header>
                        <input class="form-control" type="number" v-model="timetag.series">
                    </div>
                    <div class="BlockInputs">
                        <header>Minutes</header>
                        <input class="form-control" type="number" v-model="timetag.minutes">
                    </div>
                    <span>{{note.tag}} Time: {{this.serialTime}}</span>
                </div>
            </div>

            <!--        <span>name: {{timetag.hours}}</span>-->
            <!--        <span>name: {{timetag.minutes}}</span>-->
            <button class="btn btn-outline-success create" @click="create">Add</button>



        </div>
    </div>
</template>

<script>
    import Navbar from './Navbar';

    function TimeTag(hours,minutes,number_of_pages,percent,number_of_seasons, series, total_time_audio_books) {
        this.minutes = minutes;
        this.hours = hours;
        this.number_of_seasons = number_of_seasons;
        this.series = series;
        this.number_of_pages = number_of_pages;
        this.percent = percent;
        this.total_time_audio_books = total_time_audio_books;
    }
    function Note({id, name, desc, tag}) {
        this.id = id;
        this.name = name;
        this.desc = desc;
        this.tag = tag;
    }
    export default {
        components: {
            Navbar
        },
        data() {
            return {
                tags: [],
                note: [],
                timetag: [],
            }
        },
        mounted() {
            console.log('Component FormaddRecord mounted.');
            /* Вызываем заполнение списком тэгов */
            this.$store.dispatch('listTag');
        },
        methods: {
            async create() {
                console.log(this.note);

                /* Пишем в основную таблицу */
                const { data } =
                    await window.axios.post('/api/timelibrary', {
                        /* Основная таблица */
                        name: this.note.name,
                        desc: this.note.desc,
                        tag: this.note.tag,
                        /* Связанная таблица tracking progress */
                        minutes: this.timetag.minutes,
                        hours: this.timetag.hours,
                        number_of_seasons: this.timetag.number_of_seasons,
                        series: this.timetag.series,
                        number_of_pages: this.timetag.number_of_pages,
                        percent: this.timetag.percent,
                        total_time_audio_books: this.timetag.total_time_audio_books,
                    });
                this.note.push(new Note(data));

                /* Алерт */
                swal({
                    title: "Row added!",
                    text: 'Добавлена в базу запись: \n'+data.name+'\n В теги: '+data.tag,
                    icon: "success",
                    button: "Aww yiss!",
                });
            },
            async read() {
            },
            // async update(id, color) {
            //     this.mute = true;
            //     await window.axios.put(`/api/cruds/${id}`, { color });
            //     this.cruds.find(crud => crud.id === id).color = color;
            //     this.mute = false;
            // },
            // async del(id) {
            //     this.mute = true;
            //     await window.axios.delete(`/api/cruds/${id}`);
            //     let index = this.cruds.findIndex(crud => crud.id === id);
            //     this.cruds.splice(index, 1);
            //     this.mute = false;
            // }

            /* Записываем в глобальную шину выбранный тэг, чтобы в другом компоненте работать */
            // sendTag(tag) {
            //     this.$bus.$emit("SelectedTagOnGlobalBus", tag);
            // }
            getHoursAndMinutes(minutes){
                let hours = Math.trunc(minutes/60);
                let min = minutes % 60;
                return hours + ' Hours ' + min + ' Minutes '
            }
        },
        computed:{
            filmTime(){
                let min = (this.timetag.hours * 60) + (this.timetag.minutes * 1);
                return this.getHoursAndMinutes(min);
            },
            serialTime(){
                let min = this.timetag.number_of_seasons * this.timetag.series * this.timetag.minutes;
                return this.getHoursAndMinutes(min);
            },
        },
        // watch: {
        //     mute(val) {
        //         document.getElementById('mute').className = val ? "on" : "";
        //     }
        // },
        created() {
            this.read();
        },
    }
</script>
