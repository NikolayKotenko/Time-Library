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

                            <!-- Форма добавления / редактирования позиции -->
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <template v-for="(value_elem, index) in $store.state.defaultItem"
                                                  v-if="(index !== 'created_at') && (index !== 'updated_at') && (index !== 'id')">

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
                                <v-btn color="blue darken-1" text @click="save_update">Save</v-btn>
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
                        <!-- Меняем заголовок -->
                        <template v-slot:header.tag_id="{ headers }">
                            <span>tag_name</span>
                        </template>

                        <!-- Меняем данные в таблице идшник тэга на наименование -->
                        <template v-slot:item.tag_id="{ item }">
                            <tr>
                                <td>{{ get_tagname_for_id(item.tag_id) }}</td>
                            </tr>
                        </template>

                        <!-- Добавляем колонку с кнопками редактирования -->
                        <template v-slot:item.actions="{ item }">
                            <v-icon
                                small
                                class="mr-2"
                                @click="editItem(item)"
                            >
                                mdi-pencil
                            </v-icon>
                            <v-icon
                                small
                                @click="deleteItem(item)"
                            >
                                mdi-delete
                            </v-icon>
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
            get_tagname_for_id(tag_id){
                return this.$store.state.tags.filter((elem) => elem.id == tag_id)[0].name;
            },
            editItem (item) {
                // console.log(item);
                this.editedIndex = this.$store.state.items_table.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true;
            },
            deleteItem (item) {
                const index = this.$store.state.items_table.indexOf(item);
                confirm('Are you sure you want to delete this item?') && this.delete_row(item)
            },
            close () {
                this.dialog = false;
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.$store.state.defaultItem)
                    this.editedIndex = -1
                })
            },
            async save_update () {
                // console.log(this.editedIndex);
                /* Если выбранный индекс не отрицательный (выбрана позиция на редактирование),
                 тогда сольем объекты и получим обновленные данные, потому что реактивно и показываются из items_table */
                /* Обновление выбранной позиции */
                if (this.editedIndex > -1) {
                    Object.assign(this.$store.state.items_table[this.editedIndex], this.editedItem);

                    const upd_item = this.editedItem;
                    const id_item = this.$store.state.items_table[this.editedIndex].id;
                    // console.log(this.editedItem);
                    // console.log(this.$store.state.items_table[this.editedIndex].id);
                    /* Пишем в основную таблицу */
                    const {data} = await window.axios.put('/api/timelibrary/' + id_item, upd_item);
                    // console.log(data);
                    /* Перерисуем таблицу */
                    this.$store.dispatch('FillItemsTable', data.tag_id)

                    /* Алерт */
                    swal({
                        title: "Row updated!",
                        text: 'Обновлена запись: \n' + data.name + '\n В теги: ' + this.get_tagname_for_id(data.tag_id),
                        icon: "success",
                        button: "Aww yiss!",
                    });
                }
                /* Добавление новой позиции */
                else {
                    /* Пишем в основную таблицу */
                    // console.log(this.editedItem);
                    const {data} =
                        await window.axios.post('/api/timelibrary', this.editedItem);
                    // console.log(data);
                    /* Перерисуем таблицу */
                    this.$store.dispatch('FillItemsTable', data.tag_id)

                    /* Алерт */
                    swal({
                        title: "Row added!",
                        text: 'Добавлена в базу запись: \n' + data.name + '\n В теги: ' + this.get_tagname_for_id(data.tag_id),
                        icon: "success",
                        button: "Aww yiss!",
                    });
                }
                this.close()
            },
            async delete_row(item){
                // console.log(item);
                // this.$store.state.items_table.splice(index, 1)
                const {data} = await window.axios.delete('/api/timelibrary/' + item.id);
                // console.log(data);
                /* Перерисуем таблицу */
                this.$store.dispatch('FillItemsTable', item.tag_id)
                /* Алерт */
                swal({
                    title: "Row deleted!",
                    text: 'Удалена из базы запись: \n' + item   .name + '\n с тегом: ' + this.get_tagname_for_id(item.tag_id),
                    icon: "success",
                    button: "Aww yiss!",
                });
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
                // console.log(slot);
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
