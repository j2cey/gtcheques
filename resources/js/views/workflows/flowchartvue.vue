<template>
    <div class="container">
        <button type="button" @click="$refs.chart.add({id: +new Date(), x: 10, y: 10, name: 'New', type: 'operation', approvers: []})">
            Add
        </button>
        <button type="button" @click="$refs.chart.remove()">
            Del
        </button>
        <button type="button" @click="$refs.chart.editCurrent()">
            Edit
        </button>
        <button type="button" @click="$refs.chart.save()">
            Save
        </button>
        <flowchart :nodes="nodes" :connections="connections" @editnode="handleEditNode"
                   @dblclick="handleDblClick" @editconnection="handleEditConnection"
                   @save="handleChartSave" ref="chart">
        </flowchart>
    </div>
</template>

<script>
    /* eslint-disable no-unused-vars */
    import flowchart from 'flowchart-vue';

    export default {
        name: "flowchartvue",
        components: {
            flowchart,
        },
        data: function() {
            return {
                nodes: [
                    // Basic fields
                    {id: 1, x: 140, y: 270, name: 'Start', type: 'start'},
                    // You can add any generic fields to node, for example: description
                    // It will be passed to @save, @editnode
                    {id: 2, x: 540, y: 270, name: 'End', type: 'end', description: 'I m here'},
                ],
                connections: [
                    {
                        source: {id: 1, position: 'right'},
                        destination: {id: 2, position: 'left'},
                        id: 1,
                        type: 'pass',
                    },
                ],
            };
        },
        methods: {
            handleChartSave(nodes, connections) {
                // axios.post(url, {nodes, connections}).then(resp => {
                //   this.nodes = resp.data.nodes;
                //   this.connections = resp.data.connections;
                //   // Flowchart will refresh after this.nodes and this.connections changed
                // });
            },
            handleEditNode(node) {
                if (node.id === 2) {
                    console.log(node);
                }
            },
            handleEditConnection(connection) {
                console.log(connection);
            },
            handleDblClick(position) {
                this.$refs.chart.add({
                    id: +new Date(),
                    x: position.x,
                    y: position.y,
                    name: 'New',
                    type: 'operation',
                    approvers: [],
                });
            },
        }
    };
</script>
<style scoped>
    #toolbar {
        margin-bottom: 10px;
    }
    .title {
        margin-top: 10px;
        margin-bottom: 0;
    }
    .subtitle {
        margin-bottom: 10px;
    }
    #toolbar > button {
        margin-right: 4px;
    }
    .container {
        width: 800px;
        margin: auto;
    }
</style>
