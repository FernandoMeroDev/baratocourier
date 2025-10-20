export default class Component {
    // Livewire Logic
    wire_component_name = null;

    wire() {
        return Livewire.getByName(this.wire_component_name)[0];
    }

    async get(property) {
        return await this.wire().$get(property);
    }

    async set(property, value, live = false) {
        return await this.wire().$set(property, value, live);
    }
};