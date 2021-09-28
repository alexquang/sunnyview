<template>
    <div class="table-responsive">
        <div
            :id="`datatable${id}_wrapper`"
            class="dataTables_wrapper no-footer"
        >
            <div
                :id="`datatable${id}_info`"
                class="dataTables_info"
                role="status"
                aria-live="polite"
            >
                {{ paginationData.totalItems }} 件中 {{ paginationData.startIndex }} から {{ paginationData.endIndex }} まで表示
            </div>
            <div class="groupHeaderDatatable">
                <div
                    :id="`datatable${id}_filter`"
                    class="dataTables_filter"
                >
                    <label>
                        <i class="datatable-search-icon fas fa-search" />
                        <input
                            v-model="search"
                            type="search"
                            placeholder="キーワードを入力してください"
                            :aria-controls="`datatable${id}`"
                        >
                    </label>
                </div>
                <div
                    :id="`datatable${id}_length`"
                    class="dataTables_length"
                >
                    <label>
                        <select
                            v-model="pageSize"
                            :name="`datatable${id}_length`"
                            :aria-controls="`datatable${id}`"
                        >
                            <option
                                v-for="option in paginationOptions"
                                :key="option.key"
                                :value="option.key"
                            >
                                {{ option.name }}
                            </option>
                        </select>
                    </label>
                </div>
                <div class="dataTables_paginate paging_simple_numbers user-select-none">
                    <a
                        class="paginate_button"
                        :class="{'disabled': paginationData.currentPage == 1}"
                        :aria-controls="`datatable${id}`"
                        @click="currentPage = 1"
                    >
                        <i class="fas fa-angle-double-left" />
                    </a>
                    <span>
                        <a
                            v-for="page in paginationData.pages"
                            :key="page"
                            class="paginate_button"
                            :class="{'current': page == paginationData.currentPage}"
                            :aria-controls="`datatable${id}`"
                            @click.prevent="page && (currentPage = page)"
                        >{{ page || '...' }}</a>
                    </span>
                    <a
                        class="paginate_button"
                        :class="{'disabled': paginationData.currentPage == paginationData.totalPages}"
                        :aria-controls="`datatable${id}`"
                        @click="currentPage = paginationData.totalPages"
                    >
                        <i class="fas fa-angle-double-right" />
                    </a>
                </div>
            </div>
            <table
                :id="`datatable${id}`"
                class="dataTable display no-footer"
                :aria-describedby="`datatable${id}_info`"
                role="grid"
            >
                <thead>
                    <tr class="user-select-none">
                        <th
                            v-if="indexing"
                            class="text-center"
                        >
                            #
                        </th>
                        <th
                            v-for="header in headers"
                            :key="header.key"
                            :aria-controls="`datatable${id}`"
                            :class="{
                                [`sorting_${sort.direction}`]: sort.key === header.key || sort.key === header.sort,
                                'sorting': header.sort,
                            }"
                            @click="header.sort && changeSortOrder(header)"
                        >
                            {{ header.name }}
                        </th>
                        <th v-if="$slots.actions" />
                    </tr>
                </thead>
                <tbody v-if="paginationData.items.length == 0">
                    <tr>
                        <td :colspan="headers.length + (indexing ? 1 : 0) + ($slots.actions ? 1 : 0)">
                            {{ trans('messages.nodata') }}
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr
                        v-for="(item, index) in paginationData.items"
                        :key="item[itemKey]"
                        :class="index % 2 == 0 ? 'odd' : 'even'"
                    >
                        <td
                            v-if="indexing"
                            class="text-center"
                        >
                            {{ paginationData.startIndex + index }}
                        </td>
                        <td
                            v-for="header in headers"
                            :key="header.key"
                        >
                            <template v-if="$slots[header.key]">
                                <slot
                                    :name="header.key"
                                    :item="item"
                                    :index="index"
                                />
                            </template>
                            <template v-else>
                                {{ readKey(item, header.key) }}
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="groupFooterDatatable">
                <div
                    :id="`datatable${id}_length`"
                    class="dataTables_length"
                >
                    <label>
                        <select
                            v-model="pageSize"
                            :name="`datatable${id}_length`"
                            :aria-controls="`datatable${id}`"
                        >
                            <option
                                v-for="option in paginationOptions"
                                :key="option.key"
                                :value="option.key"
                            >
                                {{ option.name }}
                            </option>
                        </select>
                    </label>
                </div>
                <div class="dataTables_paginate paging_simple_numbers user-select-none">
                    <a
                        class="paginate_button"
                        :class="{'disabled': paginationData.currentPage == 1}"
                        :aria-controls="`datatable${id}`"
                        @click="currentPage = 1"
                    >
                        <i class="fas fa-angle-double-left" />
                    </a>
                    <span>
                        <a
                            v-for="page in paginationData.pages"
                            :key="page"
                            class="paginate_button"
                            :class="{'current': page == paginationData.currentPage}"
                            :aria-controls="`datatable${id}`"
                            @click.prevent="page && (currentPage = page)"
                        >{{ page || '...' }}</a>
                    </span>
                    <a
                        class="paginate_button"
                        :class="{'disabled': paginationData.currentPage == paginationData.totalPages}"
                        :aria-controls="`datatable${id}`"
                        @click="currentPage = paginationData.totalPages"
                    >
                        <i class="fas fa-angle-double-right" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        id: {
            type: String,
            default: 'ItemList'
        },
        headers: {
            type: Array,
            // required: true,
            default(props) {
                return _(props.items[0]).keys().map(key => {
                    return {
                        key: key,
                        name: key,
                    };
                }).value();
            }
        },
        items: {
            type: Array,
            required: true
        },
        itemKey: {
            type: String,
            default: 'id'
        },
        indexing: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            paginationOptions: [
                {'key': 10, 'name': '10件'},
                {'key': 25, 'name': '25件'},
                {'key': 50, 'name': '50件'},
                {'key': '', 'name': this.trans('labels.all')},
            ],
            search: '',
            sort: {
                key: null,
                direction: 'asc',
            },
            pageSize: 10,
            currentPage: 1,
        };
    },
    computed: {
        indexedItems() {
            return this.items.map(item => {
                item._search = this.headers.map(header => {
                    return item[header.key];
                }).join('').toLocaleLowerCase();

                return item;
            }, {});
        },
        paginationData() {
            let filteredItems = this.search ? _.filter(this.indexedItems, item => {
                return item._search.includes(this.search.toLocaleLowerCase());
            }) : this.items;

            if (this.sort.key) {
                filteredItems = _.orderBy(filteredItems, this.sort.key, [this.sort.direction]);
            }

            let data = {
                totalItems: filteredItems.length,
            };

            if (filteredItems.length == 0) {
                data.totalPages = 1;
                data.currentPage = 1;
                data.items = [];
                data.startIndex = 0;
                data.endIndex = 0;
                data.pages = [1];
            } else if (!this.pageSize) {
                data.totalPages = 1;
                data.currentPage = 1;
                data.items = filteredItems;
                data.startIndex = 1;
                data.endIndex = filteredItems.length;
                data.pages = [1];
            } else {
                data.totalPages = Math.ceil(filteredItems.length / this.pageSize);
                data.currentPage = this.currentPage > data.totalPages ? data.totalPages : this.currentPage;
                let offset = (data.currentPage - 1) * this.pageSize;
                data.items = _.drop(filteredItems, offset).slice(0, this.pageSize);
                data.startIndex = offset + 1;
                data.endIndex = offset + this.pageSize;

                if (data.endIndex > filteredItems.length) {
                    data.endIndex = filteredItems.length;
                }
                data.pages = this.generatePages(data.currentPage, data.totalPages, 2);
            }

            return data;
        },
    },
    methods: {
        readKey(item, key) {
            return _.get(item, key);
        },
        changeSortOrder(header) {
            let key = (typeof header.sort == 'string') ? header.sort : header.key;

            if (this.sort.key == key) {
                this.sort.direction = this.sort.direction == 'asc' ? 'desc' : 'asc';
            } else {
                this.sort.key = key;
                this.sort.direction = 'asc';
            }
        },
        generatePages(current, total, pad = 2) {
            let padLeft = [], padRight = [];

            let from = current - pad;
            if (from < 1) {
                from = 1;
            }

            let to = from + pad * 2;
            if (to > total) {
                to = total;
                from = to - pad * 2;

                if (from < 1) {
                    from = 1;
                }
            }

            if (from > 1) {
                padLeft = [null];
            }
            if (to < total) {
                padRight = [null];
            }

            return padLeft.concat(_.range(from, to + 1)).concat(padRight);
        },
    }
};
</script>

<style scoped>

</style>
