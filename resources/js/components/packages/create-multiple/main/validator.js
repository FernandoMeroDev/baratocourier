import Component from "../../../component";

class Validator extends Component
{
    wire_component_name = 'packages.create-multiple.main';

    constructor(categories, current_client_id)
    {
        super();
        this.current_client_id = current_client_id;
        let dict = {};
        for(let category of categories)
            dict[category.code] = {id: category.id, name: category.name}
        this.categories = dict;
    }

    generation_available = true;

    weights_kg = {};

    current_client_id = null;

    categories = null;
    // Type:
    // categories = {
    //     '<code>': {id: '<id>', name: '<name>'}
    //     'a': {id: '3', name: 'A (documentos) 4X4'}
    //     ...
    // }

    shipping_address_visible = true;

    async handleAddressSelected(event) {
        this.shipping_address_visible = false;
        let el = document.getElementById('current_shipping_address_selected');
        el.textContent = 'Dirección: ' + event.detail.address;
    }

    // Validar solo en el Backend
    async checkCategoryAviability(i) {
        const price = await this.get(`form.prices.${i}`) ?? 0,
              weight = this.lbToKg(await this.get(`form.weights.${i}`) ?? 0, i);
        this.changeCategoryAviability('a', price <= 2 && weight <= 2);
        this.changeCategoryAviability('b', price <= 400 && weight <= 4);
        this.changeCategoryAviability('g', price <= 470 && weight <= 4);
        this.changeCategoryAviability('d', weight <= 20);
        this.changeCategoryAviability('c', price <= 5000 && weight <= 100);
    }

    async changeCategoryAviability(code, available) {
        const el = document.getElementById(`package_category_${code}`);
        if(available)
            el.hidden = false;
        else {
            el.hidden = true;
            await this.clearCategory(code);
            this.checkPersonTypeAviability({target: {value: code}});
        }
    }

    async clearCategory(code) {
        const current = await this.get('form.category_id'),
              category_id = this.categories[code].id;
        if(current == category_id){
            await this.set('form.category_id', null);
            alert('El paquete no cumple los requisitos de la categoría seleccionada.');
        }
    }

    lbToKg(lb_value, i) {
        const kg_value = (lb_value / 2.20462).toFixed(2);
        this.weights_kg[i] = kg_value;
        return kg_value;
    }

    personal_data_enabled = {};

    personal_data_visible = {};

    async setPersonalDataVisible() {
        let e = document.getElementById('main-form');
        setTimeout(() => {
            e.setAttribute('wire:ignore', 'true');
        }, 1000)
        let packages_count = await this.get('packages_count'),
            category_id = await this.get('form.category_id');
        for(let i = 0; i < packages_count; i++)
            this.personal_data_visible[i] = true;
        if(category_id !== null)
            this.checkPersonTypeAviability({target: {value: category_id}});
    }

    handlePersonSelected(event, i) {
        if(i !== event.detail.i) return; // Checks what input was clicked
        this.personal_data_visible[i] = false;
        let el = document.getElementById(`current_person_selected_${i}`);
        el.textContent = 'Persona: ' + event.detail.name + ', Cédula: ' + event.detail.identity_card;
    }

    async checkPersonTypeAviability(event) {
        const category_id = event.target.value;
        const packages_count = await this.get('packages_count');
        // Check PersonalData aviability
        if(category_id == null || category_id === ''){
            for(let i = 0; i < packages_count; i++)
                this.personal_data_enabled[i] = false;
            for(let i = 0; i < packages_count; i++)
                this.personal_data_visible[i] = true;
            await this.set('form.person_types', []);
            await this.set('form.person_ids', []);
            return;
        } else {
            for(let i = 0; i < packages_count; i++){
                this.personal_data_enabled[i] = true;
            }
        }
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
    }

    async changePersonTypeAviability(type_name, available) {
        const elements = document.querySelectorAll(`.person_type_${type_name}`);
        if(available)
            for(const node of elements){
                node.disabled = false;
            }
        else {
            let i = 0;
            for(const node of elements){
                node.disabled = true;
                await this.clearPersonType(type_name, i);
                this.personal_data_visible[i] = true;
                i++;
            }
        }
    }

    async clearPersonType(type, i) {
        const current = await this.get(`form.person_types.${i}`);
        if(current == type){
            this.personal_data_visible[i] = true;
            await this.set(`form.person_types.${i}`, null);
        }
    }

    async checkPersonTypeSelection(event, i) {
        let type_name = event.target.value;
        if('client' == type_name)
            await this.set(`form.persons_id.${i}`, this.current_client_id);
        else
            await this.set(`form.persons_id.${i}`, null); // Must search and select person
    }
}

const validator = (categories, current_client_id) => (
    new Validator(categories, current_client_id)
);

Alpine.data('validator', validator);