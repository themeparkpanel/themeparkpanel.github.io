function click(selector, callback) {
    document.addEventListener('click', e => {
        if(!e.target)
            return

        if(!e.target.matches(selector))
            return

        callback(e.target)
    })
}

click("#template_toggle", template_switch => {
    let is_template = document.getElementById('is_template')
    is_template.parentElement.parentElement.parentElement.style.display = template_switch.checked === true ? 'none' : 'block'

    let permission = document.getElementById('permission')
    permission.style.display = template_switch.checked === true ? 'none' : is_template.checked ? 'none' : 'table'

    document.getElementById('start_command').style.display = template_switch.checked === true ? 'none' : is_template.checked ? 'none' : 'table'
    document.getElementById('stop_command').style.display = template_switch.checked === true ? 'none' : is_template.checked ? 'none' : 'table'
    document.getElementById('template').style.display = template_switch.checked === true ? 'table' : 'none'

    let items = permission.parentElement.querySelector("div[id=items]")
    items = items.querySelectorAll('input')
    items.forEach(value => {
        let name = value.getAttribute('name')
        if (name.endsWith('[0]'))
            return

        if (name.endsWith('[3]')) {
            value.parentElement.style.display = template_switch.checked === true ? 'table' : is_template.checked ? 'none' : 'table'
        } else {
            value.parentElement.style.display = template_switch.checked === true ? 'none' : 'table'
        }
    })
})

click('#is_template', template_switch => {
    let permission = document.getElementById('permission')
    permission.style.display = template_switch.checked === true ? 'none' : 'table'

    document.getElementById('start_command').style.display = template_switch.checked === true ? 'none' : 'table'
    document.getElementById('stop_command').style.display = template_switch.checked === true ? 'none' : 'table'

    let items = permission.parentElement.querySelector("div[id=items]")
    items = items.querySelectorAll('input')
    items.forEach(value => {
        let name = value.getAttribute('name')
        if(!name.endsWith('[3]'))
            return

        value.parentElement.style.display = template_switch.checked === true ? 'none' : 'table'
    })
})

click('h3 > .btn', btn => {
    let group = btn.parentElement.parentElement;
    if(!group)
        return

    if(btn.innerHTML === 'Add Item') {
        addItem(group)
    } else if(btn.innerHTML === 'Add State') {
        addState(group)
    }
})

click('.toggle > .fas', toggle => {
    let group = toggle.parentElement.parentElement.parentElement;
    let states = group.querySelector("div[id^=states_]")
    if(!states)
        return

    let hidden = states.style.display === 'none';
    states.style.display = hidden ? 'block' : 'none';

    if(hidden) {
        toggle.classList.remove('fa-chevron-circle-down')
        toggle.classList.add('fa-chevron-circle-up')
    } else  {
        toggle.classList.add('fa-chevron-circle-down')
        toggle.classList.remove('fa-chevron-circle-up')
    }
})

click('#sync', () => rideExport())

function rideExport() {
    let data = serialize(document.getElementById('operator-form'))
    if(!data.hasOwnProperty('id') || !data.hasOwnProperty('template_toggle') || !data['items'] || !data['states'])
        return

    if(data['template_toggle']) {
        delete data['permission']
        if(!data['template'])
            return
    } else {
        delete data['template']
        if(data['is_template']) {
            delete data['permission']
        } else if(!data.hasOwnProperty('permission'))
            return
    }

    let use_template = data['template_toggle']
    let is_template = data['is_template']
    delete data['template_toggle']
    delete data['is_template']

    let items = data['items']
    data['items'] = {}
    items.forEach(value => {
        let obj = {}
        if(!use_template) {
            obj['name'] = value[1]
            obj['active_state'] = value[2]
        }

        obj['states'] = {}
        data['items'][value[0]] = obj
    })

    let states = data['states']
    delete data['states']
    states.forEach((value, index) => {
        let item = items[index]
        value.forEach(value => {
            let obj = {}
            if(!use_template) {
                obj['name'] = value[1]
                obj['cover'] = value[2]
                if(!is_template)
                    obj['command'] = value[3]

                obj['text_color'] = value[4]
                obj['background_color'] = value[5]
                obj['glow'] = value[6]
            } else {
                obj['command'] = value[3]
            }

            data['items'][item[0]]['states'][value[0]] = obj
        })
    })

    Object.entries(data['items']).forEach(entry => {
        if(cleanItems(entry[1]))
            delete data['items'][entry[0]]
    })

    document.getElementById('file_name').innerHTML = data['id']+'.json'
    delete data['id']

    document.getElementById('output').innerHTML = JSON.stringify(data, null, 2)
        .replace('\n', '<br>')
}

function addItem(group) {
    let items = group.querySelector("div[id=items]")
    if(!items)
        return

    let items_size = group.querySelectorAll('div[id=items] > .group')
    if(!items_size)
        return

    let style = document.getElementById('template_toggle').checked ? ' style="display: none"' : ''

    items_size = items_size.length;
    items.insertAdjacentHTML('beforeend',
        '                    <div class="group">\n' +
        '                        <div class="input-group mb-3">\n' +
        '                            <span class="input-group-addon"><i class="fas fa-tag"></i></span>\n' +
        '                            <input type="text" class="form-control" name="items['+items_size+'][0]" placeholder="ID">\n' +
        '                        </div>\n' +
        '                        <div class="input-group mb-3"'+style+'>\n' +
        '                            <span class="input-group-addon"><i class="fas fa-signature"></i></span>\n' +
        '                            <input type="text" class="form-control" name="items['+items_size+'][1]" placeholder="Name">\n' +
        '                        </div>\n' +
        '                        <div class="input-group mb-3"'+style+'>\n' +
        '                            <span class="input-group-addon"><i class="fas fa-toggle-on"></i></span>\n' +
        '                            <input type="text" class="form-control" name="items['+items_size+'][2]" placeholder="Active State">\n' +
        '                        </div>\n' +
        '\n' +
        '                        <h3>States <span class="toggle"><i class="fas fa-chevron-circle-up"></i></span> <a class="btn btn-primary">Add State</a></h3>\n' +
        '                        <div id="states_'+items_size+'">\n' +
        '                        </div>' +
        '                    </div>')
}

function addState(group) {
    let states = group.querySelector("div[id^=states_]")
    if(!states)
        return

    let index = parseInt(states.id.replace('states_', ''))
    if(!index && index !== 0)
        return

    let states_size = states.getElementsByClassName('group')
    if(!states_size)
        return

    let style = document.getElementById('template_toggle').checked ? ' style="display: none"' : ''

    states_size = states_size.length;
    states.insertAdjacentHTML('beforeend',
        '                   <div class="group">\n' +
        '                            <div class="input-group mb-3">\n' +
        '                                <span class="input-group-addon"><i class="fas fa-tag"></i></span>\n' +
        '                                <input type="text" class="form-control" name="states['+index+']['+states_size+'][0]" placeholder="ID">\n' +
        '                            </div>\n' +
        '                            <div class="input-group mb-3"'+style+'>\n' +
        '                                <span class="input-group-addon"><i class="fas fa-signature"></i></span>\n' +
        '                                <input type="text" class="form-control" name="states['+index+']['+states_size+'][1]" placeholder="Name">\n' +
        '                            </div>\n' +
        '                            <div class="input-group mb-3"'+style+'>\n' +
        '                                <span class="input-group-addon"><i class="fas fa-image"></i></span>\n' +
        '                                <input type="text" class="form-control" name="states['+index+']['+states_size+'][2]" placeholder="Cover">\n' +
        '                            </div>\n' +
        '                            <div class="input-group">\n' +
        '                                <span class="input-group-addon"><i class="fas fa-terminal"></i></span>\n' +
        '                                <input type="text" class="form-control" name="states['+index+']['+states_size+'][3]" placeholder="Command">\n' +
        '                            </div>\n' +
        '                            <div class="input-group">\n' +
        '                                <span class="input-group-addon"><i class="fas fa-tint"></i></span>\n' +
        '                                <input type="text" class="form-control" name="states['+index+']['+states_size+'][4]" placeholder="Text Color" value="#fff">\n' +
        '                            </div>\n' +
        '                            <div class="input-group">\n' +
        '                                <span class="input-group-addon"><i class="fas fa-tint"></i></span>\n' +
        '                                <input type="text" class="form-control" name="states['+index+']['+states_size+'][5]" placeholder="Background Color" value="#666">\n' +
        '                            </div>\n' +
        '                            <div class="settings">\n' +
        '                                <div class="settings-toggle">\n' +
        '                                   <label class="switcher">\n' +
        '                                       <input name="states['+index+']['+states_size+'][6]" type="checkbox">\n' +
        '                                       <span class="switcher-slider"></span>\n' +
        '                                   </label>\n' +
        '                               </div>\n' +
        '                               <div class="settings-text" style="float: unset">\n' +
        '                                   <p>Glows</p>\n' +
        '                               </div>\n' +
        '                           </div>\n' +
        '                       </div>\n')
}

function cleanItems(data) {
    let b = false;
    Object.entries(data).forEach(entry => {
        let key = entry[0]
        let value = entry[1]
        if(!key || !value) {
            delete data[key]
            b = true
            return
        }

        if(typeof value === 'object') {
            if (cleanItems(value)) {
                if (JSON.stringify(value) === '{}') {
                    delete data[key]
                    b = true
                }
            }
        }
    })

    return b
}

function serialize(element) {
    if(!element)
        return {}

    let inputs = element.querySelectorAll('input')
    if(!inputs)
        return {}

    let out = {}
    inputs.forEach(value => {
        let name = value.getAttribute('name')
        if(!name)
            return

        if(!name.endsWith(']')) {
            out[name] = getValue(value)
            return
        }

        serializeNested(out, name, getValue(value))
    })

    return out
}

function serializeNested(out, name, val) {
    let matches = [...name.matchAll(/\[([0-9]+)\]/g)]
    name = name.replaceAll(/(\[([0-9]+)\])+/g, '')

    let array;
    if(out.hasOwnProperty(name)) {
        array = out[name]
    } else {
        array = []
        out[name] = array
    }

    matches.forEach((value, index) => {
        let id = value[1]
        if(index === (matches.length - 1)) {
            array[id] = val
        } else {
            if (array.hasOwnProperty(id)) {
                array = array[id]
            } else {
                array[id] = []
                array = array[id]
            }
        }
    })
}

function getValue(element) {
    if(element.matches('[type="checkbox"]'))
        return element.checked

    return element.value
}
