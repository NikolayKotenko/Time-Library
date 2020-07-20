<template>
    <div>
        <navbar></navbar>
        <div id="vuetify-table">
            <v-app id="inspire">
                <v-card>
                    <v-card-title>
                        Diary
                        <v-spacer></v-spacer>
                        <v-text-field
                            v-model="$store.state.search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-card-title>


                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="primary"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                            >New Item</v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{  }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field  label="Dessert name"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field  label="Calories"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field  label="Fat (g)"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field  label="Carbs (g)"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field label="Protein (g)"></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>



                    <v-select v-if="$store.state.headers_table" v-model="enabled" :items="$store.state.slots" label="Choose Tag" clearable></v-select>
                    <v-data-table
                        :headers="$store.state.headers_table"
                        :items="$store.state.items_table"
                        :items-per-page="5"
                        :sort-by="['tag', 'percent']"
                        :sort-desc="[false, true]"
                        multi-sort
                        :search="$store.state.search"
                        class="elevation-1"
                        >
                    </v-data-table>
                </v-card>
            </v-app>
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
                note: [],
                timetag: [],
                enabled: null,
                dialog: false,
                editedIndex: -1,
            }
        },
        mounted() {
            console.log('Form edit record mounted.');
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
                // const { data } = await window.axios.get('/api/tag');
                // data.forEach(tag => this.tags.push(new Tag(tag)));
                // console.log(data);
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
            },
            close () {
                this.dialog = false;
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                })
            },
            save () {
                if (this.editedIndex > -1) {
                    Object.assign(this.desserts[this.editedIndex], this.editedItem)
                } else {
                    this.desserts.push(this.editedItem)
                }
                this.close()
            },
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
            showSelect () {
                return this.isEnabled('header.data-table-select') || this.isEnabled('item.data-table-select')
            },
            hideHeaders () {
                return !this.showSelect
            },
            isLoading () {
                return this.isEnabled('progress')
            },
        },
        watch: {
            /* Переключение тэгов в выпадающем списке */
            enabled (slot) {
                if (!!slot) {
                    let id_tag = this.$store.state.tags.filter(function (elem) {
                        if (elem.name === slot) {
                            return elem.id;
                        }
                    })[0].id;
                    this.$store.dispatch('FillItemsTable', id_tag);
                }
                else {
                    this.$store.state.items_table = [];
                }
                return this.$store.state.items_table;
            },
            dialog (val) {
                val || this.close()
            },
        },
        // watch: {
        //     mute(val) {
        //         document.getElementById('mute').className = val ? "on" : "";
        //     }
        // },
        created() {
            console.log('Form edit record');
            // this.read();
        },
    }
</script>
