const validator = (categories) => ({
    // Livewire Logic
    wire_component_name: 'packages.create.main',

    wire() {
        return Livewire.getByName(this.wire_component_name)[0];
    },

    async get(property) {
        return await this.wire().$get(property);
    },

    async set(property, value, live = false) {
        return await this.wire().$set(property, value, live);
    },

    // Component Logic
    async init() {
        let dict = {};
        for(let category of categories)
            dict[category.code] = {id: category.id, name: category.name}
        this.categories = dict;
    },

    weight_kg: 0,

    categories: null,
    // Type:
    // categories = {
    //     '<code>': {id: '<id>', name: '<name>'}
    //     'a': {id: '3', name: 'A (documentos) 4X4'}
    //     ...
    // }

    async checkCategoryAviability() {
        const price = await this.get('form.price') ?? 0,
              weight = this.lbToKg(await this.get('form.weight') ?? 0);
        if(price <= 2 && weight <= 2)
            this.changeCategoryAviability('a', true);
        else {
            this.changeCategoryAviability('a', false);
            await this.clearCategory('a');
        }
        if(price <= 400 && weight <= 4)
            this.changeCategoryAviability('b', true);
        else {
            this.changeCategoryAviability('b', false);
            await this.clearCategory('b');
        }
        if(price <= 470 && weight <= 4)
            this.changeCategoryAviability('g', true);
        else {
            this.changeCategoryAviability('g', false);
            await this.clearCategory('g');
        }
        if(weight <= 20)
            this.changeCategoryAviability('d', true);
        else {
            this.changeCategoryAviability('d', false);
            await this.clearCategory('d');
        }
        if(price <= 5000 && weight <= 100)
            this.changeCategoryAviability('c', true);
        else {
            this.changeCategoryAviability('c', false);
            await this.clearCategory('c');
        }
    },

    changeCategoryAviability(code, status) {
        const el = document.getElementById(`package_category_${code}`);
        el.hidden = ! status;
    },

    async clearCategory(code) {
        const current = await this.get('form.category_id'),
              category_id = this.categories[code].id;
        if(current == category_id)
            await this.set('form.category_id', null);
    },

    lbToKg(lb_value) {
        const kg_value = (lb_value / 2.20462).toFixed(2);
        this.weight_kg = kg_value;
        return kg_value;
    },

    personal_data_enabled: false,

    personal_data_visible: true,

    async handlePersonSelected() {
        this.personal_data_visible = false;
        const savePerson = async () => {
            this.wire().$call(
                'savePersonSelected',
                await this.get('form.person_id'),
                await this.get('form.person_type'),
            );
        };
        let person_id = await this.get('form.person_id');
        if(person_id === null) setTimeout(savePerson, 300);
        else savePerson();

    },

    async checkPersonTypeAviability(event) {
        const category_id = event.target.value;
        // Check PersonalData aviability
        if(category_id == null || category_id === ''){
            this.personal_data_enabled = false;
            await this.set('form.person_type', null);
            await this.set('form.person_id', null);
            return;
        } else
            this.personal_data_enabled = true;
        // Check Client aviability
        await this.changePersonTypeAviability(
            'client',
            category_id == this.categories['b'].id
                || category_id == this.categories['c'].id
                || category_id == this.categories['a'].id
                || category_id == this.categories['special'].id
                || category_id == this.categories['d'].id
        );
        // Check Receivers aviability
        await this.changePersonTypeAviability(
            'receiver',
            category_id == this.categories['b'].id
                || category_id == this.categories['a'].id
                || category_id == this.categories['special'].id
        );
        // Check FamilyCoreMembers aviability
        await this.changePersonTypeAviability(
            'family_core_member',
            category_id == this.categories['a'].id
            || category_id == this.categories['special'].id
            || category_id == this.categories['g'].id
        );
    },

    async changePersonTypeAviability(type_name, available) {
        let el = document.getElementById(`person_type_${type_name}`);
        if(available)
            el.disabled = false;
        else {
            el.disabled = true;
            await this.clearPersonType(type_name);
        }
    },

    async clearPersonType(type) {
        const current = await this.get('form.person_type');
        if(current == type)
            await this.set('form.person_type', null);
    },

    async checkPersonTypeSelection(event) {
        let type_name = event.target.value;
        if('client' == type_name)
            // [TODO] set true current Client ID
            await this.set('form.person_id', 1);
        else
            await this.set('form.person_id', null); // Must search and select person
    },
});

Alpine.data('validator', validator);