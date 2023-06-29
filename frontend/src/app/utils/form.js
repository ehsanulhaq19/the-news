
/**
 * Convert normal object array to dropdown array
 * @param {*} array 
 */
export const convertToDropdownArray = (array) => {
    const dropdownArray = array.map(obj => {
        return {
            label: obj.name,
            value: obj.id
        }
    })

    return dropdownArray
}