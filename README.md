Under construction


     * That nested case will be corrected and fully supported
     * {% softdeleteable %}
     *    <span>
     *       {% softdeleteable 'Acme\Bundle\CoreBundle\Entity\Foo' %}
     *           {% softdeleteable %}
     *               {% softdeleteable 'Acme\Bundle\CoreBundle\Entity\Bar' %}
     *                   {{ object.owner.fullName }}
     *               {% endsoftdeleteable %}
     *           {% endsoftdeleteable %}
     *       {% endsoftdeleteable %}
     *    </span>
     * {% endsoftdeleteable %}