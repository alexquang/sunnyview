<template>
    <div>
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="dataTable-top pb-0">
                    <div class="dataTable-dropdown mb-3">
                        <Input
                            v-model="pageSize"
                            type="select"
                            :options="paginationOptions"
                        />
                    </div>
                    <div class="dataTable-search mb-3">
                        <input
                            v-model="search"
                            class="dataTable-input"
                            placeholder="キーワードを入力してください..."
                            type="search"
                        >
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-centered table-striped table-nowrap mb-0 rounded">
                        <thead class="thead-dark user-select-none">
                            <tr>
                                <th
                                    v-if="indexing"
                                    class="border-0"
                                >
                                    #
                                </th>
                                <th
                                    v-for="header in headers"
                                    :key="header.key"
                                    class="border-0"
                                    :class="{
                                        [`sort-${sort.direction}`]: sort.key === header.key || sort.key === header.sort,
                                        'sortable': header.sort,
                                    }"
                                    @click="header.sort && changeSortOrder(header)"
                                >
                                    {{ header.name }}
                                </th>
                                <th
                                    v-if="$slots.actions"
                                    class="border-0"
                                />
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
                            >
                                <td v-if="indexing">
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
                                <td
                                    v-if="$slots.actions"
                                    class="text-end"
                                >
                                    <slot
                                        name="actions"
                                        :item="item"
                                        :index="index"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="dataTable-bottom">
                    <div class="dataTable-info">
                        {{ paginationData.totalItems }} 件中 {{ paginationData.startIndex }} から {{ paginationData.endIndex }} まで表示
                    </div>
                    <nav class="dataTable-pagination">
                        <ul class="dataTable-pagination-list user-select-none mb-0">
                            <li
                                class="pager"
                                :class="{'disabled': paginationData.currentPage == 1}"
                            >
                                <a @click="currentPage = 1">‹‹</a>
                            </li>
                            <li
                                class="pager"
                                :class="{'disabled': paginationData.currentPage == 1}"
                            >
                                <a @click="paginationData.currentPage > 1 && --currentPage">‹</a>
                            </li>
                            <li
                                v-for="page in paginationData.pages"
                                :key="page"
                                :class="{'active': page == paginationData.currentPage}"
                            >
                                <a
                                    href="#"
                                    @click.prevent="page && (currentPage = page)"
                                >{{ page || '...' }}</a>
                            </li>
                            <li
                                class="pager"
                                :class="{'disabled': paginationData.currentPage == paginationData.totalPages}"
                            >
                                <a @click="paginationData.currentPage < paginationData.totalPages && ++currentPage">›</a>
                            </li>
                            <li
                                class="pager"
                                :class="{'disabled': paginationData.currentPage == paginationData.totalPages}"
                            >
                                <a @click="currentPage = paginationData.totalPages">››</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Input from '@/Shared/Forms/Input';

export default {
    components: {
        Input,
    },
    props: {
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
                {'key': 5, 'name': '5件'},
                {'key': 10, 'name': '10件'},
                {'key': 25, 'name': '25件'},
                {'key': 50, 'name': '50件'},
                {'key': 100, 'name': '100件'},
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
                if (this.sort.direction == 'desc') {
                    this.sort.key = null;
                    this.sort.direction = 'asc';
                } else {
                    this.sort.direction = 'desc';
                }
                // this.sort.direction = this.sort.direction == 'asc' ? 'desc' : 'asc';
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
    th:first-child,
    .table-responsive {
        border-top-left-radius: 0.35rem;
    }
    th:last-child,
    .table-responsive {
        border-top-right-radius: 0.35rem;
    }
    td, th {
        padding-left: 1rem !important;
    }
    th {
        padding-right: 2.2rem !important;
    }
    th.sortable {
        cursor: pointer;
    }
    th.sort-asc {
        background-image: url("/images/sort_asc.svg");
    }
    th.sort-desc {
        background-image: url("/images/sort_desc.svg");
    }
    th.sort-asc,
    th.sort-desc
    {
        background-repeat: no-repeat;
        background-position: calc(100% - 5px) 55%;
        background-size: 1.2rem;
        background-color: #151f2c
    }
    td {
        vertical-align: middle;
    }
    .card-body {
        padding: 1.5rem;
    }
</style>
