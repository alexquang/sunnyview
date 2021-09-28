<template>
    <div class="row">
        <div class="col-12">
            <p>This page was made to make sure your components are working as expected.</p>
            <TabGroup id="test">
                <Tab
                    id="form-input-test"
                    name="Form Input Test"
                    active
                >
                    <FormInputTest />
                </Tab>
                <Tab
                    id="table-test"
                    name="Table"
                >
                    <TableTest />
                </Tab>
            </tabgroup>
        </div>
    </div>
</template>

<script>
import FormInputTest from '@/Tests/FormInputTest';
import TableTest from '@/Tests/TableTest';
import TabGroup from '@/Shared/Tabs/TabGroup';
import Tab from '@/Shared/Tabs/Tab';

export default {
    components: {
        TabGroup,
        Tab,
        FormInputTest,
        TableTest,
    },
};
</script>
