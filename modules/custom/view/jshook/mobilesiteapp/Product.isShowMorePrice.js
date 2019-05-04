(function()
{
    //Если есть подкатегории    
    if (this.category && (this.category['id'] == 2) && !parseInt(this.is_empty_bottle)) {
        return true;
    }
    return false;
})