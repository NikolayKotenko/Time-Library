let store = {
    state: {
        tags: [],
        /* Select Tag */
        slots: [],
        /* Table */
        headers_table: [
            { text: 'name', align: 'start', sortable: false, value: 'name',},
            { text: 'description', value: 'description' },
            { text: 'tag', value: 'tag' },
            { text: 'minutes', value: 'minutes' },
            { text: 'hours', value: 'hours' },
            { text: 'number of seasons', value: 'number_of_seasons' },
            { text: 'series', value: 'series' },
            { text: 'number of pages', value: 'number_of_pages' },
            { text: 'percent', value: 'percent' },
            { text: 'total time audio books', value: 'total_time_audio_books' },
        ],
        items_table: [],
        /* CRUD */
        defaultItem: [],
    },
    getters: {
        tag_name : state => {
            return state.tags.name
        }
    },
    actions: {
        async listTag (context) {
            const response = await window.axios.get('/api/tag');
            // const arr_tag_name = response.data.map(tag => tag.name);
            context.commit('ADD_TAG_TO_LIST', response.data)
        },
        async FillItemsTable (context, queryParam) {
            const response = await window.axios.get('/api/timelibrary/'+queryParam);
            const headers_table = [];
            let list_editedItems = {};
            for (let key in response.data[0]){
                headers_table.push(new Headers_table_structure(key));
            }
            // console.log(response.data[0]);
            list_editedItems = new DefaultItem_destruct(response.data[0]);

            const data = {
                'headers_table': headers_table,
                'defaultItem': list_editedItems,
                'items_table': response.data,
            };
            // const arr_tag_name = response.data.map(tag => tag.name);
            context.commit('FILL_ITEMS_TABLE', data);
        },
    },
    mutations: {
        ADD_TAG_TO_LIST(state, payload) {
            state.tags = payload;
            state.slots = payload.map((elem) => elem.name);
        },
        FILL_ITEMS_TABLE(state, payload) {
            state.headers_table = payload.headers_table;
            state.items_table = payload.items_table;

            state.defaultItem = payload.defaultItem;
        },
        // myMutation (state, myDataObject) {
        //     state.myData = myDataObject
        // }
    }
};

/* Вспомогательная ф-я конструктор */
function Headers_table_structure(header) {
    this.text = header;
    this.value = header;
}
function DefaultItem_destruct({name, description, tag_id, minutes, number_of_seasons,
                        series, number_of_pages, percent, total_time_audio_books, created_at, updated_at, id}) {
    if (tag_id) {
        this.tag_id = tag_id;
    }
    if (name) {
        this.name = '';
    }
    if (description) {
        this.description = '';
    }
    if (minutes) {
        this.minutes = 0;
    }
    if (number_of_seasons) {
        this.number_of_seasons = 0;
    }
    if (series) {
        this.series = 0;
    }
    if (number_of_pages) {
        this.number_of_pages = 0;
    }
    if (percent) {
        this.percent = 0;
    }
    if (total_time_audio_books) {
        this.total_time_audio_books = 0;
    }
    if (created_at) {
        this.created_at = '';
    }
    if (updated_at) {
        this.updated_at = '';
    }
}

export default store;
