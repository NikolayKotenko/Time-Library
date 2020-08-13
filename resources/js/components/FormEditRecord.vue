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

                            <!-- Форма добавления новой позиции -->
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <template v-for="(value_elem, index) in $store.state.defaultItem"
                                                  v-if="(index !== 'created_at') && (index !== 'updated_at')">

                                            <v-col cols="12" sm="12" md="12">
                                                <v-select v-if="(index === 'tag_id')" v-model="enabled" :items="$store.state.slots" label="Your Tag" clearable></v-select>
                                                <v-text-field v-else :label="index" v-model="editedItem[index]"></v-text-field>
                                            </v-col>

                                        </template>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>



                    <v-select v-if="$store.state.headers_table" v-model="enabled" :items="$store.state.slots" label="Choose Tag" clearable></v-select>
                    <v-data-table
                        :headers="$store.state.headers_table"
                        :items="$store.state.items_table"
                        :items-per-page="10"
                        :sort-by="['tag', 'percent']"
                        :sort-desc="[false, true]"
                        multi-sort
                        :search="$store.state.search"
                        class="elevation-1"
                        >
                        <!-- Нумерация -->
                        <template #item="{ item, index, headers }">
                            <tr>
                                <td v-for="n in headers">
                                    {{ n.value === 'id' ? index : item[n.value] }}
                                </td>
                            </tr>
                        </template>
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
                count: 0,
                note: [],
                timetag: [],
                enabled: null,
                dialog: false,
                editedIndex: -1,
                editedItem: {},
            }
        },
        mounted() {
            console.log('Form edit record mounted.');

            /* Вызываем заполнение списком тэгов. Дальше ожидаем ответа (промис) и заполняем по умолчанию нужным тегом */
            this.$store.dispatch('listTag').then(() => {
                this.enabled = this.$store.state.slots[2];
            });
        },
        methods: {
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
            editItem (item) {
                this.editedIndex = this.desserts.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true;
            },
            deleteItem (item) {
                const index = this.desserts.indexOf(item);
                confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
            },
            close () {
                this.dialog = false;
                this.$nextTick(() => {
                    // this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },
            async save () {
                if (this.editedIndex > -1) {
                    Object.assign(this.desserts[this.editedIndex], this.editedItem)
                } else {

                    /* Пишем в основную таблицу */
                    console.log(this.editedItem);
                    const { data } =
                        await window.axios.post('/api/timelibrary', this.editedItem);
                    console.log(data.tag_id);
                    /* Перерисуем таблицу */
                    this.$store.dispatch('FillItemsTable', data.tag_id)

                    /* Алерт */
                    swal({
                        title: "Row added!",
                        text: 'Добавлена в базу запись: \n'+data.name+'\n В теги: '+data.tag,
                        icon: "success",
                        button: "Aww yiss!",
                    });

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
                console.log(slot);
                if (!!slot) {
                    let id_tag = this.$store.state.tags.filter(function (elem) {
                        if (elem.name === slot) {
                            return elem.id;
                        }
                    })[0].id;
                    this.$store.dispatch('FillItemsTable', id_tag).then(() => {
                        /* Заполняем локальные данные editedItem*/
                        this.editedItem = this.$store.state.defaultItem;
                    });
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
