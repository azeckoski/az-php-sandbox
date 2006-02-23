<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"  version="1.0">
<xsl:output method="text" disable-output-escaping="yes"/>

<xsl:variable name="field_enclosure_character">^</xsl:variable>
<xsl:variable name="field_separation_character">,</xsl:variable>
<xsl:variable name="subfield_separation_character">|</xsl:variable>
<xsl:variable name="carriage_return"><xsl:text>
</xsl:text></xsl:variable>
<xsl:template match="/">
  <xsl:text>JIRAKEY,SUMMARY,DESCRIPTION,COMPONENT,AUDIENCE</xsl:text>
  <xsl:value-of select="$carriage_return"/>

  <xsl:apply-templates select="/rss/channel/item"/>
</xsl:template>

<xsl:template match="item">
  <xsl:apply-templates select="key"/>
  <xsl:value-of select="$field_separation_character"/>

  <xsl:apply-templates select="summary"/>
  <xsl:value-of select="$field_separation_character"/>

  <xsl:apply-templates select="description"/>
  <xsl:value-of select="$field_separation_character"/>

  <xsl:apply-templates select="component"/>
  <xsl:value-of select="$field_separation_character"/>
  
  <xsl:value-of select="$field_enclosure_character"/>
  <xsl:apply-templates select="customfields/customfield[customfieldname = 'Target Audience(s)']/customfieldvalues/customfieldvalue"/>
  <xsl:value-of select="$field_enclosure_character"/>

  <xsl:value-of select="$carriage_return"/>
</xsl:template>

<xsl:template match="customfieldvalue">
  <xsl:if test="position() &gt; 1">
    <xsl:value-of select="$subfield_separation_character"/>
  </xsl:if>
  <xsl:value-of select="."/>
</xsl:template>

<xsl:template match="*">
  <xsl:value-of select="$field_enclosure_character"/>
  <xsl:value-of select="."/>
  <xsl:value-of select="$field_enclosure_character"/>
</xsl:template>

</xsl:stylesheet>