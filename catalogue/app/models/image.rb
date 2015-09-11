class Image < ActiveRecord::Base
  belongs_to :produit
  attr_accessible :chemin
end
