let store = {
    state: {
        tags: [],
        /* Select Tag */
        slots: [],
        /* Table */
        headers_table: [],
        items_table: [],
        /* CRUD */
        defaultItem: [],
        /* Описываем поля которые должны отрисовываться в таблице */
        CommonFieldTags: ['created_at', 'updated_at', 'name', 'description'],
        CustomFieldTags: {
            'films': ['minutes', 'hours'],
            'podcasts': ['minutes', 'hours'],
            'video-self-dev': ['minutes', 'hours'],
            'audio-books': ['percent', 'total_time_audio_books'],
            'books': ['percent', 'number_of_pages'],
            'serials': ['number_of_seasons', 'series', 'minutes'],
            'anime': ['number_of_seasons', 'series', 'minutes'],
        },
    },
    getters: {
        tag_name : state => {
            return state.tags.name
        },
    },
    actions: {
        async listTag (context) {
            const response = await window.axios.get('/api/tag');
            // const arr_tag_name = response.data.map(tag => tag.name);
            context.commit('ADD_TAG_TO_LIST', response.data)
        },
        async FillItemsTable (context, tag_id) {
            const response = await window.axios.get('/api/timelibrary/'+tag_id);
            let headers_table = [];
            let defaultItem = {};

            /* Найдем имя тега чтобы найти структуру по описанию */
            const name_tag = context.state.tags.filter((elem) => elem.id == tag_id)[0].name;
            // console.log(name_tag);

            /* Заполним первым тэг id, чтобы в объекте был на 1 строчке*/
            defaultItem['tag_id'] = tag_id;

            /* Общими полями заполняем объект */
            for (let key in context.state.CommonFieldTags) {
                const value = context.state.CommonFieldTags[key];
                headers_table.push(new Headers_table_structure(value));
                defaultItem[value] = '';
            }
            /* Кастомные поля для каждого тэга */
            for (let key in context.state.CustomFieldTags){
                const value = context.state.CustomFieldTags[key];
                if (key === name_tag) {
                    value.forEach((elem) => {
                        headers_table.push(new Headers_table_structure(elem));
                            defaultItem[elem] = '';
                    });
                }
            }
            /* Кнопки действия в конце таблицы расположим */
            headers_table.push({'text': 'actions', 'value': 'actions', 'width': '80px', 'sortable': false});

            console.log(headers_table);
            console.log(defaultItem);

            const data = {
                'headers_table': headers_table,
                'defaultItem': defaultItem,
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
    if (header === 'updated_at' || header === 'created_at') {
        this.width = '120px';
    }
    if (header === 'name') {
        this.width = '250px';
    }
    this.text = header;
    this.value = header;
}

export default store;
